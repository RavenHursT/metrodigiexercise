<?php
require_once(__DIR__ . '/lib/BaseModel.php');

class WeatherApi extends BaseModel{
    protected
        $_request = NULL,
        $_weatherSourceRequest = NULL,
        $_results;

    public function __construct($request = NULL){
        if(!$request){
            throw new Exception('Request required.');
        }

        $this->setRequest($request);
    }

    protected function _handleResponse(){
        header('Content-type: application/json');
        echo json_encode($this->getResults());
        exit;
    }

    public function getMethod(){
        $qResult = DB::query("SELECT * FROM sfo_data where timestamp = '" . $this->getRequest()['timestamp'] . "'");
        if(count($qResult)){
            if(count($qResult) > 1){
                throw new Exception('There should not be multiple records w/ the same timestamp. Data is corrupt.');
            }
            $this->setResults($qResult[0]);
        } else {
            $this->setWeatherSourceRequest(
                new Weather_Source_API_Requests(
                    $request_method     = 'GET',
                    $request_path       = 'history_by_postal_code',
                    $request_parameters = array(
                        'postal_code_eq' => 94128,
                        'country_eq' => 'US',
                        'timestamp_eq' => $this->getRequest()['timestamp'],
                        'fields' => 'tempMax,tempMin,tempAvg'
                    )
                )
            );
            Weather_Source_API_Requests::finish();

            $result = $this->getWeatherSourceRequest()->get_result()[0];
            $this->setResults(array(
                'timestamp' =>  $this->getRequest()['timestamp'],
                'temp_min'  =>  $result['tempMin'],
                'temp_max'  =>  $result['tempMax'],
                'temp_avg'  =>  $result['tempAvg']
            ));
            DB::insert('sfo_data', $this->getResults());
        }
        $this->_handleResponse();
    }

    public function postMethod(){

    }

    public function putMethod(){

    }

    public function deleteMethod(){

    }
}