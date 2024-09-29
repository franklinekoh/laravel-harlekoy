<?php

namespace App\Services;

class ThirdPartyService
{
//    We could have required services inject in the constructor. e.g guzzle http client
    public function __construct(){}

    /**
     * @param  array  $subscribers
     * @return array API response from network call
     */
    public function postSubscribersData(array $subscribers): array{

        $postData = [
            'batches' => [
                'subscribers' => $subscribers
            ]
        ];

        /**
         * Make API call here with  above data
         *
         * try{
                 network call
         * }catch($e){
         *      Log failure
         * }
         */


        /**
         * Returns API response to be used to mark fields in database as updated as well as storing
         * the response in DB for debugging purposes
         */
        return [
            'success' => true,
            'data' => [
                [
                    'email' => 'ekohfranklin@gmail.com',
                    'name' => 'Franklin Ekoh',
                    'timezone' => 'GMT + 1'
                ]
            ]
        ];
    }
}
