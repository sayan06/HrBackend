<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AddressSeeder::class,
            AisleSeeder::class,
            AutoCreateEventsSeeder::class,
            BusinessNatureSeeder::class,
            CellItemSeeder::class,
            CellSeeder::class,
            CellStatusSeeder::class,
            InvoiceStatusSeeder::class,
            ItemSeeder::class,
            ItemTypeSeeder::class,
            ItemVariantSeeder::class,
            ManufactureOrderSeeder::class,
            MoStatusSeeder::class,
            MediaTypeSeeder::class,
            MoVariantSeeder::class,
            MoPartSeeder::class,
            ManufacturingOutputSheetSeeder::class,
            OrderInvoiceSeeder::class,
            OutputSheetStatusSeeder::class,
            PartyItemSeeder::class,
            PartySeeder::class,
            PickSheetItemSeeder::class,
            PickSheetSeeder::class,
            PickOrderStatusSeeder::class,
            PoInvoiceSeeder::class,
            PoItemPartSeeder::class,
            PoItemSeeder::class,
            PoItemStatusSeeder::class,
            PoStatusSeeder::class,
            PurchaseOrderSeeder::class,
            RolesAndPermissionSeeder::class,
            SalesOrderSeeder::class,
            SoItemSeeder::class,
            SoStatusSeeder::class,
            UomSeeder::class,
            UserSeeder::class,
            WarehouseSeeder::class,
        ]);
    }
}
