<?php

namespace App\Hr\Commands;

use File;
use Illuminate\Support\Str;

final class MakeRepository extends HrCommand
{
    const COMMAND_ENTITY = 'Repository';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = HrCommand::NAMESPACE_COMMAND.':make-repo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a repository and its contract.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('Enter the name of the '.self::COMMAND_ENTITY.'?');
        $name = ucfirst($name);
        $contractsDirectory = $this->getRepoContractsDirPath();
        $repoDirectory = $this->getRepoDirPath();

        $contractFileName = $contractsDirectory.'/'.$name.self::COMMAND_ENTITY.'Interface.php';
        $repoFileName = $repoDirectory.'/'.$name.self::COMMAND_ENTITY.'.php';

        if (empty($name)) {
            $this->error(self::COMMAND_ENTITY.' Name Invalid..!');
        }

        // Make directories if it is not present
        if (! file_exists($contractsDirectory) && ! file_exists($repoDirectory)) {
            mkdir($contractsDirectory, 0775, true);
            mkdir($repoDirectory, 0775, true);
            $this->info('Directories created.');
        }

        if (! file_exists($contractFileName) && ! file_exists($repoFileName)) {
            $contractFileContent = $this->getContractFileContent($name);
            $contractBytesWritten = $this->makeFile($contractFileName, $contractFileContent);
            $repoFileContent = $this->getRepositoryFileContent($name);
            $repoBytesWritten = $this->makeFile($repoFileName, $repoFileContent);

            if ($contractBytesWritten && $repoBytesWritten) {
                $this->info(self::COMMAND_ENTITY.' Files Created Successfully.');

                return;
            }
        }

        $this->error($name.self::COMMAND_ENTITY.' Files Already Exists.');
    }

    private function getRepoContractsDirPath(): string
    {
        return app_path('/'.self::NAMESPACE_PROJECT.'/'.$this->getPluralizedEntity().'/Contracts');
    }

    private function getRepoDirPath(): string
    {
        return app_path('/'.self::NAMESPACE_PROJECT.'/'.$this->getPluralizedEntity());
    }

    private function makeFile(string $name, string $content = '')
    {
        return File::put($name, $content);
    }

    private function getContractFileContent(string $name): string
    {
        $projectNamespace = HrCommand::NAMESPACE_PROJECT;
        $pluralizedEntity = $this->getPluralizedEntity();

        return "<?php\n\nnamespace App\\{$projectNamespace}\\{$pluralizedEntity}\\Contracts;\n\ninterface ".$name.self::COMMAND_ENTITY."Interface\n{\n}";
    }

    private function getRepositoryFileContent(string $name): string
    {
        $projectNamespace = HrCommand::NAMESPACE_PROJECT;
        $pluralizedEntity = $this->getPluralizedEntity();

        return "<?php\n\nnamespace App\\{$projectNamespace}\\{$pluralizedEntity};\n\nuse App\\{$projectNamespace}\\{$pluralizedEntity}\\Contracts\\".$name.self::COMMAND_ENTITY."Interface;\n\nuse App\Hr\\".$pluralizedEntity."\Base".self::COMMAND_ENTITY.";\n\nfinal class ".$name.self::COMMAND_ENTITY.' extends Base'.self::COMMAND_ENTITY.' implements '.$name.self::COMMAND_ENTITY."Interface\n{\n}";
    }

    private function getPluralizedEntity(): string
    {
        return Str::plural(self::COMMAND_ENTITY);
    }
}
