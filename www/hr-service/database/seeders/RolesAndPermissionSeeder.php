<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class RolesAndPermissionSeeder extends Seeder
{
    private $addressPermissions = [
        'create_addresses',
        'delete_addresses',
        'list_addresses',
        'update_addresses',
    ];

    private $aislePermissions = [
        'create_aisles',
        'delete_aisles',
        'list_aisles',
        'update_aisles',
    ];

    private $authPermissions = [
        'change_user_password',
        'create_tokens',
        'list_permissions',
        'list_roles',
        'list_users',
        'update_user',
    ];

    private $bomItemPermissions = [
        'create_bom_items',
        'delete_bom_items',
        'list_bom_items',
        'update_bom_items',
    ];

    private $bomPermissions = [
        'create_boms',
        'delete_boms',
        'list_boms',
        'update_boms',
    ];

    private $businessPermissions = [
        'create_businesses',
    ];

    private $cellItemPermissions = [
        'create_cell_items',
        'delete_cell_items',
        'list_cell_items',
        'update_cell_items',
    ];

    private $cellPermissions = [
        'create_cells',
        'delete_cells',
        'list_cells',
        'update_cells',
    ];

    private $collectionPermissions = [
        'create_collection_items',
        'create_collections',
        'delete_collections',
        'list_collections',
        'update_collection_items',
    ];

    private $invoicePermissions = [
        'create_invoices',
        'delete_invoices',
        'delete_purchase_order_items',
        'list_invoice_statuses',
        'list_invoices',
        'update_invoices',
    ];

    private $itemPermissions = [
        'create_items',
        'delete_items',
        'list_items',
        'list_item_types',
        'update_items',
    ];

    private $labelPermissions = [
        'assign_label',
        'delete_label',
        'generate_label',
        'list_labels',
        'print_label',
        'scan_label',
    ];

    private $manufactureOrderPermissions = [
        'create_manufacture_order',
        'delete_manufacture_order',
        'list_manufacture_order_statuses',
        'list_manufacture_orders',
        'update_manufacture_order',
    ];

    private $manufacturedOutputSheetPermissions = [
        'create_output_sheet',
        'delete_manufacture_order_parts',
        'delete_output_sheet',
        'list_output_sheet_statuses',
        'list_output_sheets',
        'update_output_sheet',
    ];

    private $mediaPermissions = [
        'delete_media',
        'download_medias',
        'upload_medias',
    ];

    private $partyPermissions = [
        'add_party_items',
        'create_parties',
        'delete_parties',
        'delete_party_items',
        'get_party_items',
        'list_parties_by_business',
        'list_parties',
        'update_parties',
    ];

    private $partyItemPermissions = [
        'update_party_items',
    ];

    private $pickOrderPermissions = [
        'create_pick_orders',
        'delete_pick_orders',
        'list_pick_order_item_statuses',
        'list_pick_order_statuses',
        'list_pick_orders',
        'update_pick_orders',
    ];

    private $pickSheetPermissions = [
        'create_pick_sheets',
        'delete_pick_sheets',
        'list_pick_sheet_statuses',
        'list_pick_sheets',
        'update_pick_sheets',
    ];

    private $purchaseOrderPermissions = [
        'create_purchase_orders',
        'delete_purchase_order_statuses',
        'list_purchase_order_statuses',
        'list_purchase_orders',
        'update_purchase_orders',
    ];

    private $reportsPermissions = [
        'aged_Inventory',
        'low_stock',
        'product_performance',
        'repeat_customer',
        'turnover_report',
        'repeat_order_rate',
        'stock_details',
    ];

    private $rolePermissions = [
        'assign_permissions',
        'create_roles',
        'delete_roles',
        'list_role_permissions',
        'update_roles',
    ];

    private $salesOrderPermissions = [
        'create_sales_orders',
        'delete_sales_orders',
        'list_sales_orders',
        'list_so_statuses',
        'update_sales_orders',
    ];

    private $stockPermissions = [
        'create_stocks',
        'list_stocks',
        'update_stocks',
    ];

    private $uomPermissions = [
        'create_uom',
        'delete_uom',
        'list_uom',
        'update_uom',
    ];

    private $variantPermissions = [
        'create_variants',
        'delete_variants',
        'list_variants',
        'update_variants',
    ];

    private $warehousePermissions = [
        'add_warehouse_users',
        'create_warehouses',
        'delete_warehouse_users',
        'delete_warehouses',
        'list_warehouse_users',
        'list_warehouses',
        'update_warehouses',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::with('permission')->delete();
        Permission::with('role')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Permission::insert(array_map(
            fn ($permission) => ['guard_name' => 'web', 'name' => $permission],
            $this->getAllPermissions()
        ));

        $this->createRole('factory_manager')->givePermissionTo([
            'change_user_password',
            'list_manufacture_orders',
            'list_pick_sheets',
            'update_user',
        ]);

        $this->createRole('guest')->givePermissionTo(
            'change_user_password',
            'list_items',
            'list_purchase_orders',
            'list_variants',
            'update_user',
        );

        $this->createRole('production_manager')->givePermissionTo([
            array_merge(
                $this->manufactureOrderPermissions,
                $this->pickOrderPermissions,
            ),
            'change_user_password',
            'update_user',
        ]);

        $this->createRole('qa_manager')->givePermissionTo(
            $this->invoicePermissions,
            'change_user_password',
            'update_user',
        );

        $this->createRole('sales_manager')->givePermissionTo([
            array_merge(
                $this->pickOrderPermissions,
                $this->purchaseOrderPermissions,
                $this->salesOrderPermissions,
            ),
            'change_user_password',
            'update_user',
        ]);

        $this->createRole('store_manager')->givePermissionTo([
            array_merge(
                $this->collectionPermissions,
                $this->labelPermissions,
                $this->pickSheetPermissions,
            ),
            'change_user_password',
            'update_user',
        ]);

        $this->createRole('super_admin')->givePermissionTo($this->getAllPermissions());
    }

    private function getAllPermissions()
    {
        return array_merge(
            $this->addressPermissions,
            $this->aislePermissions,
            $this->authPermissions,
            $this->bomItemPermissions,
            $this->bomPermissions,
            $this->businessPermissions,
            $this->cellItemPermissions,
            $this->cellPermissions,
            $this->collectionPermissions,
            $this->invoicePermissions,
            $this->itemPermissions,
            $this->labelPermissions,
            $this->manufactureOrderPermissions,
            $this->manufacturedOutputSheetPermissions,
            $this->mediaPermissions,
            $this->partyPermissions,
            $this->partyItemPermissions,
            $this->pickOrderPermissions,
            $this->pickSheetPermissions,
            $this->purchaseOrderPermissions,
            $this->reportsPermissions,
            $this->rolePermissions,
            $this->salesOrderPermissions,
            $this->stockPermissions,
            $this->uomPermissions,
            $this->variantPermissions,
            $this->warehousePermissions,
        );
    }

    private function createRole(string $roleName): Role
    {
        return Role::create(['name' => $roleName]);
    }
}
