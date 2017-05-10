<?php

use Illuminate\Database\Seeder;

class CountryStatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = array_values(array_merge(array_map(function($state) {
            return ['country' => 'United States', 'state' => $state];
        }, $this->_getUSStates()), array_map(function($state) {
            return ['country' => 'India', 'state' => $state];
        }, $this->_getIndianStates())));

        array_walk($records, function($record) {
            factory(\App\CountryStates::class)->create($record);
        });
    }

    /**
     * _getUSStates
     *
     * method to get US states
     * created Sep 16, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _getUSStates() {
        $states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming', 'District of Columbia', 'American Samoa', 'Guam', 'Northern Mariana Islands', 'Puerto Rico', 'U.S. Virgin Islands'];
        sort($states);
        return $states;
    }

    /**
     * _getIndianStates
     *
     * method to get indian states
     * created Sep 16, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _getIndianStates() {
        $states = ['Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chandigarh', 'Chhattisgarh', 'Dadra and Nagar Haveli', 'Daman and Diu', 'National Capital Territory of Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jammu and Kashmir', 'Jharkhand', 'Karnataka', 'Kerala', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'];
        sort($states);
        return $states;
    }
}
