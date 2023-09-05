<?php

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = new \App\Models\Customer();
        $customer->customer_code = '00250';
        $customer->name = 'Nguyen Van A';
        $customer->tax_code = '00024-GTVT';
        $customer->name_company = 'Cong ty Thinh Tam Duong';
        $customer->address = '243 Nguyen Xien';
        $customer->account_number = '19327873230012';
        $customer->name_bank = 'Techcombank';
        $customer->payments = 'Tiền mặt';
        $customer->customer_type = 'Cá nhân';
        $customer->phone_number = '0812306676';
        $customer->email = 'nguyenvana@gmail.com';
        $customer->created_at = now();
        $customer->updated_at = now();
        $customer->save();

        $customer = new \App\Models\Customer();
        $customer->customer_code = '00251';
        $customer->name = 'Nguyen Van B';
        $customer->tax_code = '00025-GTVT';
        $customer->name_company = 'Cong ty Thinh Tam Duong1';
        $customer->address = '243 Nguyen Xien';
        $customer->account_number = '19327873230012';
        $customer->name_bank = 'Techcombank';
        $customer->payments = 'Chuyển khoản';
        $customer->customer_type = 'Doanh nghiệp';
        $customer->phone_number = '08162060987';
        $customer->email = 'nguyenvanb@gmail.com';
        $customer->created_at = now();
        $customer->updated_at = now();
        $customer->save();

        $customer = new \App\Models\Customer();
        $customer->customer_code = '00252';
        $customer->name = 'Nguyen Van C';
        $customer->tax_code = '00026-GTVT';
        $customer->name_company = 'Cong ty Thinh Tam Duong2';
        $customer->address = 'so 1 hang bo';
        $customer->account_number = '19327873345340012';
        $customer->name_bank = 'MB';
        $customer->payments = 'Tiền mặt';
        $customer->customer_type = 'Doanh nghiệp';
        $customer->phone_number = '08162060987';
        $customer->email = 'nguyenvanc@gmail.com';
        $customer->created_at = now();
        $customer->updated_at = now();
        $customer->save();
    }
}
