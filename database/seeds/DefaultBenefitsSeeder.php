<?php

use Illuminate\Database\Seeder;

class DefaultBenefitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $benefits = [
                ['name' => 'Philhealth', 'photo' => 'https://pbs.twimg.com/profile_images/1228104642527023104/1NzlUM6-_400x400.jpg'],
                ['name' => 'Pag-ibig', 'photo' => 'https://edgedavao.net/wp-content/uploads/2019/03/pagibig-fund-logo.jpg'],
                ['name' => 'SSS', 'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/Social_Security_System_%28SSS%29.svg/1200px-Social_Security_System_%28SSS%29.svg.png'],
                ['name' => 'TIN', 'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/54/Bureau_of_Internal_Revenue_%28BIR%29.svg/1200px-Bureau_of_Internal_Revenue_%28BIR%29.svg.png'],
            ];
            $current_benefits = \HCES\Benefits::all();
            foreach ($benefits as $benefit) {
                if ($current_benefits->where('name', $benefit['name'])->first() != null) {
                    continue;
                }
                $benefit = new \HCES\Benefits($benefit);
                $benefit->save();
            }
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}
