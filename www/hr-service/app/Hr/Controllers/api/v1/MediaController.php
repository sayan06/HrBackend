<?php

namespace App\Hr\Controllers\api\v1;

use App\Hr\Controllers\api\ApiController;
use App\Hr\Models\EntityMedia;
use App\Hr\Models\Media;
use App\Hr\Repositories\Contracts\MediaRepositoryInterface;
use App\Hr\Resources\MediaResource;
use App\Hr\Services\Contracts\MediaServiceInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class MediaController extends ApiController
{
    private const MEDIA_UPLOAD_PATH = 'public/media';
    private const MODEL_PATH = 'App\Hr\Models';
    private $mediaService;
    private $mediaRepo;

    public function __construct(MediaServiceInterface $mediaService, MediaRepositoryInterface $mediaRepo)
    {
        $this->mediaRepo = $mediaRepo;
        $this->mediaService = $mediaService;
    }

    public function updateMediaItems(Request $request, Media $media)
    {
        $rules = [
            'entity_id' => 'required|int|min:1',
            'entity' => 'required|string',
            'media_type_id' => 'required|numeric|gte:1|exists:media_types,id',
            'mediafile' => 'prohibited',
        ];

        $request->validate($rules);

        $this->validateAssignedEntities($request->all());

        $destinationPath = self::MEDIA_UPLOAD_PATH;
        $file = $request->file('mediafile');
        $extension = $file->getClientOriginalExtension();
        $customMediaName = $request->entity . $request->entity_id . '.' . $extension;
        $path = $file->storeAs($destinationPath, $customMediaName);

        $modelNamespace = $this->getModelNamespace($request->entity);

        $mediaDetails = [
            'media_id' => $request->id,
            'path' => $path,
            'name' => $customMediaName,
            'created_by' => request()->user()->id,
            'reference_model' => $modelNamespace,
        ];

        if (Media::where('path', $mediaDetails['path'])->count() > 0) {
            throw new BadRequestException('Media already saved');
        }

        $this->mediaService->updateMediaItems($media, $request->all(), $mediaDetails);

        return $this->respondSuccess('File Uploaded Succecssfully', new MediaResource($media));
    }

    public function getMediaItems(Request $request, Media $media)
    {
        $rules = [
            'entity' => 'required|string',
            'entity_id' => 'required|int|min:1',
        ];

        $request->validate($rules);

        $modelNamespace = $this->getModelNamespace($request->entity);

        $this->validateAssignedEntities($request->all());

        if (EntityMedia::where('entity', $modelNamespace)->where('entity_id', $request->entity_id)->count() === 0) {
            throw new BadRequestException('No such media uploaded');
        }

        $attributeDetails = [
            'entity' => $modelNamespace,
            'entity_id' => $request->entity_id,
        ];

        return $this->respond(MediaResource::collection($this->mediaRepo->getMediaItems($media, $attributeDetails)));
    }

    public function deleteMedia(Media $media)
    {
        return $this->respondSuccess('Media deleted successfully!', new MediaResource($this->mediaService->deleteMedia($media)));
    }

    private function getModelNamespace(string $referenceAttribute): string
    {
        return self::MODEL_PATH . '\\' . $referenceAttribute;
    }

    private function validateAssignedEntities(array $entityData = [])
    {
        $modelPath = $this->getModelNamespace($entityData['entity']);

        if (!class_exists($modelPath)) {
            throw new BadRequestException('Model does not exist');
        }

        $modelPath::findOrFail($entityData['entity_id']);
    }
}
