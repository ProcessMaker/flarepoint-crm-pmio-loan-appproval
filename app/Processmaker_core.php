<?php
namespace App;

use Illuminate\Http\Request;
use App\Models\Integration;
//use App\Events\TaskAction;
use App\Models\Activity;
use App\Models\Task;
use App\Models\User;
use GuzzleHttp;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Processmaker_core
{
    protected $client;
    protected static $organizationId;
    protected static $accessToken;
    protected static $clientId;
    protected static $clientSecret;
    protected static $apiKey;
    protected static $host;

    /*function __construct() {
        parent::__costruct();

    }*/



    protected function getClient()
    {
        /*if (!$this->client) {
            $this->client = new \GuzzleHttp\Client();

            $res = $this->client->request('GET', 'https://restapi.e-conomic.com/customers', [
                'verify' => false,
                'headers' => [
                    'X-AppSecretToken:' => 'demo',
                    'X-AgreementGrantToken' => 'demo',
                    'Content-Type' => 'application/json'
                ]
            ]);
            $response = self::convertJson($res);
            self::$accessToken = $response->access_token;
        }
        return $this->client;*/
    }

    public static function getContacts()
    {
        /*$res = self::getClient()->request('GET', 'https://restapi.e-conomic.com/customers ');

        return json_decode($res->getBody(), true);*/
    }

    /** Triggering start event
     * @param Task $data
     */

    public static function triggerStartEvent($data)
    {
        /** string $host */
        $host = Integration::whereApiType('processmaker_core')->pluck('host')->first();

        /** @var GuzzleHttp\Client $client */
        $client = new GuzzleHttp\Client([
            'base_uri' => "https://$host"
        ]);

        /** Call API Start event */
        try {
            $response = $client->request('GET','/processes/Loan%20Request/events/Loan%20Requested/webhook', [
                'headers' => [
                    'Authorization' => "Bearer ".Auth()->user()->access_token,
                    'Accept'    => 'application/json'
                    ],
                'query' => [
                    'amount'    => $data->getAttribute('amount'),
                    'case_id'   => $data->getAttribute('id'),
                    'crm_callback'  => route('callback')
                ]
                ]);

            self::toLog(array_merge([
                'text' => 'Response from:'.$host.'<br>'.$response->getBody()->getContents(),
                'user_id' => Auth()->id(),
                'source_type' =>  Task::class,
                'source_id' =>  $data->getAttribute('id'),
                'action' => 'created'
            ]));
        } catch (\Exception $e) {
            self::toLog(array_merge([
                'text' => 'Response from:'.$host.'<br>'.$e->getMessage(),
                'user_id' => Auth()->id(),
                'source_type' =>  Task::class,
                'source_id' =>  $data->getAttribute('id'),
                'action' => 'created'
            ]));
            $data->setAttribute('status', 5);
            $data->save();
        }

    }

    /** Get credentials for registered user
     * @param User $data
     */

    public static function getCredentials($data)
    {
        /** string $host */
        $host = 'https://'.Integration::whereApiType('Processmaker_core')->pluck('host')->first();

        /** @var GuzzleHttp\Client $client */
        $client = new GuzzleHttp\Client([
            'base_uri' => 'https://'.Integration::whereApiType('Processmaker_core')->pluck('host')->first().'/api/v1/'
        ]);

        try {

            $response = $client->request('GET','users/create', [
                'headers' => [
                    'content-type' => "application/json",
                    'Authorization' => "Bearer ".Auth()->user()->access_token,
                    'Accept'    => 'application/json'
                ],
                'json' => [
                'data' => [
                    'type' => 'user',
                    'attributes' => [
                        'content' => [
                            'username'    => $data->getAttribute('name'),
                            'password'   => $data->getAttribute('password'),
                            'firstname' => $data->getAttribute('name'),
                            'lastname' => $data->getAttribute('name'),
                            'status'  => 'ACTIVE',
                            'email'  => $data->getAttribute('email'),
                            ]
                        ]
                    ]
                ]
            ]);

            self::toLog(array_merge([
                'text' => 'Response from:'.$host.'<br>'.$response->getBody()->getContents(),
                'user_id' => Auth()->id(),
                'source_type' =>  User::class,
                'source_id' =>  $data->getAttribute('id'),
                'action' => 'created'
            ]));

            /*'json' => [
                'data' => [
                    'type' => 'data_model',
                    'attributes' => [
                        'content' => [
                            'amount'    => $data->getAttribute('amount'),
                            'case_id'   => $data->getAttribute('id')
                            ]
                        ]
                    ]
                ]*/


        } catch (\Exception $e) {
            self::toLog(array_merge([
                'text' => 'Response from:'.$host.'<br>'.$e->getMessage(),
                'user_id' => Auth()->id(),
                'source_type' =>  User::class,
                'source_id' =>  $data->getAttribute('id'),
                'action' => 'created'
            ]));

        }
    }

    /** Save to activity
     *@param array $data
     */
    private static function toLog($data) {
        Activity::create($data);
    }


}
