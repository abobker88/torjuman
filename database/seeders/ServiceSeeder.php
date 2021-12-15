<?php

namespace Database\Seeders;

use App\Models\notificationModel;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

       Service::create([
            'name_ar'=>'ترجمة الورقة الواحدة',
            'name_en'=>'One sheet translation',
            'price' => 10.5,
            'code'=>'ONS',
            'icon'=>'files/service.png',
            'color'=>'#FFF4E5',
            'service_type'=>'1',
            'description_ar'=>'ترجمة الورقة الواحدة',
            'description_en'=>'ترجمة الورقة الواحدة',
            'background_icon'=>'files/background.svg'
        ]);

        Service::create([
            'name_ar'=>'ترجمة 10 اوراق فأقل',
            'name_en'=>'Translation of 10 papers or less',
            'price' => 60.5,
            'code'=>'TNS',
            'icon'=>'files/service.png',
            'color'=>'#FFDAD7',
            'service_type'=>'1',
            'description_ar'=>'ترجمة 10 اوراق فأقل',
            'description_en'=>'ترجمة الورقة الواحدة',
            'background_icon'=>'files/background.svg'
        ]);

        Service::create([
            'name_ar'=>'ترجمة البحوث والكتب',
            'name_en'=>'Translation of research and books',
            'code'=>'TRB',
            'icon'=>'files/service.png',
            'color'=>'#DDF5DC',
            'service_type'=>'1',
            'description_ar'=>'ترجمة البحوث والكتب',
            'description_en'=>'ترجمة الورقة الواحدة',
            'background_icon'=>'files/background.svg'
        ]);

       Service::create([
            'name_ar'=>'الترجمة المعتمدة',
            'name_en'=>'Certified translation',
            'code'=>'CT',
            'icon'=>'files/service.png',
            'color'=>'#CAEFEC',
            'service_type'=>'1',
            'description_ar'=>'الترجمة المعتمدة',
            'description_en'=>'ترجمة الورقة الواحدة',
            'background_icon'=>'files/background.svg'
        ]);

        Service::create([
            'name_ar'=>'طلب مترجم فوري',
            'name_en'=>'Request an interpreter',
            'code'=>'RI',
            'icon'=>'files/service.png',
            'color'=>'#CAEFEC',
            'service_type'=>'2',
            'description_ar'=>'طلب مترجم فوري',
            'description_en'=>'ترجمة الورقة الواحدة',
            'background_icon'=>'files/background.svg'
        ]);

        Service::create([
            'name_ar'=>'خدمات الشركات والمؤسسات',
            'name_en'=>'Corporate and Institutional Services',
            'code'=>'CIS',
            'icon'=>'files/service.png',
            'color'=>'#DDF5DC',
            'service_type'=>'3',
            'description_ar'=>'خدمات الشركات والمؤسسات',
            'description_en'=>'ترجمة الورقة الواحدة',
            'background_icon'=>'files/background.svg'
        ]);

        Service::create([
            'name_ar'=>' صياغة الخطابات',
            'name_en'=>'Drafting letters',
            'code'=>'DL',
            'icon'=>'files/service.png',
            'color'=>'#FFF4E5',
            'service_type'=>'2',
            'description_ar'=>'صياغة الخطابات',
            'description_en'=>'ترجمة الورقة الواحدة',
            'background_icon'=>'files/background.svg'
        ]);

        Service::create([
            'name_ar'=>'التجربة المجانية',
            'name_en'=>'Free trial',
            'code'=>'FT',
            'icon'=>'files/service.png',
            'color'=>'#FFDAD7',
            'service_type'=>'2',
            'description_ar'=>'التجربة المجانية',
            'description_en'=>'ترجمة الورقة الواحدة',
            'background_icon'=>'files/background.svg'
        ]);

notificationModel::create([
    'order_id'=>1,
    'to_id'=>7,
    'type'=>'message_from_translator',
    'content'=>'there new message'
]);    

notificationModel::create([
    'order_id'=>1,
    'to_id'=>7,
    'type'=>'message_from_customer_service',
    'content'=>'there new message'
]);
notificationModel::create([
    'order_id'=>1,
    'to_id'=>7,
    'type'=>'order_status_change',
    'content'=>'there new message'
]);
    }
}
