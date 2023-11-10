<?php

namespace Database\Seeders;

use App\Models\CancellationPolicy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CancellationPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entries = [
            [
                'service' => 'activity',
                'before_7_days' => 5,
                'within_24_hours' => 20,
                'less_than_24_hours' => 100,
                'policy_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl.',
                'policy_ar' => 'لوريم ايبسوم دولار سيت اميت, كونسيكتيتور اديبيسسينج ايليت. نوللا اويسمود, نيسل جيت اولتريس ايليكوام, كوام نيسل ايليكويت نونك, كويس ايليكوام نيسل نونك كويس نيسل.',
            ],

            [
                'service' => 'flight',
                'before_7_days' => 5,
                'within_24_hours' => 20,
                'less_than_24_hours' => 100,
                'policy_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl.',
                'policy_ar' => 'لوريم ايبسوم دولار سيت اميت, كونسيكتيتور اديبيسسينج ايليت. نوللا اويسمود, نيسل جيت اولتريس ايليكوام, كوام نيسل ايليكويت نونك, كويس ايليكوام نيسل نونك كويس نيسل.',
            ],

            [
                'service' => 'hotel',
                'before_7_days' => 5,
                'within_24_hours' => 20,
                'less_than_24_hours' => 100,
                'policy_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl.',
                'policy_ar' => 'لوريم ايبسوم دولار سيت اميت, كونسيكتيتور اديبيسسينج ايليت. نوللا اويسمود, نيسل جيت اولتريس ايليكوام, كوام نيسل ايليكويت نونك, كويس ايليكوام نيسل نونك كويس نيسل.',
            ],

            [
                'service' => 'transfer',
                'before_7_days' => 5,
                'within_24_hours' => 20,
                'less_than_24_hours' => 100,
                'policy_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl.',
                'policy_ar' => 'لوريم ايبسوم دولار سيت اميت, كونسيكتيتور اديبيسسينج ايليت. نوللا اويسمود, نيسل جيت اولتريس ايليكوام, كوام نيسل ايليكويت نونك, كويس ايليكوام نيسل نونك كويس نيسل.',
            ],

            [
                'service' => 'visa',
                'before_7_days' => 5,
                'within_24_hours' => 20,
                'less_than_24_hours' => 100,
                'policy_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl.',
                'policy_ar' => 'لوريم ايبسوم دولار سيت اميت, كونسيكتيتور اديبيسسينج ايليت. نوللا اويسمود, نيسل جيت اولتريس ايليكوام, كوام نيسل ايليكويت نونك, كويس ايليكوام نيسل نونك كويس نيسل.',
            ],

            [
                'service' => 'umrah',
                'before_7_days' => 5,
                'within_24_hours' => 20,
                'less_than_24_hours' => 100,
                'policy_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl.',
                'policy_ar' => 'لوريم ايبسوم دولار سيت اميت, كونسيكتيتور اديبيسسينج ايليت. نوللا اويسمود, نيسل جيت اولتريس ايليكوام, كوام نيسل ايليكويت نونك, كويس ايليكوام نيسل نونك كويس نيسل.',
            ],

            [
                'service' => 'ziyarat',
                'before_7_days' => 5,
                'within_24_hours' => 20,
                'less_than_24_hours' => 100,
                'policy_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl. Nulla euismod, nisl eget ultricies aliquam, quam nisl aliquet nunc, quis aliquam nisl nunc quis nisl.', 
                'policy_ar' => 'لوريم ايبسوم دولار سيت اميت, كونسيكتيتور اديبيسسينج ايليت. نوللا اويسمود, نيسل جيت اولتريس ايليكوام, كوام نيسل ايليكويت نونك, كويس ايليكوام نيسل نونك كويس نيسل.',
            ],
        ];

        foreach ($entries as $entry) {
            CancellationPolicy::create($entry);
        }
    }
}
