<?php
        require 'vendor/autoload.php';
    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\RequestException;
    use GuzzleHttp\Psr7\Request;
    Class CloudwaysAPI
    {
        private $client = null;
        const API_URL = "https://api.cloudways.com/api/v1";
        var $auth_key;
        var $auth_email;
        var $accessToken;
        public
        function __construct($email,$key)
        {
            $this->auth_email = $email;
            $this->auth_key = $key;
            $this->client = new Client();
            $this->prepare_access_token();
        }

        public
        function prepare_access_token()
        {
            try
            {
                $url = self::API_URL . "/oauth/access_token";
                $data = ['email' => $this->auth_email,'api_key' => $this->auth_key];
                $response = $this->client->post($url, ['query' => $data]);
                $result = json_decode($response->getBody()->getContents());
                $this->accessToken = $result->access_token;
            }

            catch (RequestException $e)
            {
                $response = $this->StatusCodeHandling($e);
                return $response;
            }

        }

        public
        function StatusCodeHandling($e)
        {

            if ($e->getResponse()->getStatusCode() == '400')
            {
                $this->prepare_access_token();
            }

            elseif ($e->getResponse()->getStatusCode() == '422')
            {
                $response = json_decode($e->getResponse()->getBody(true)->getContents());
                return $response;
            }

            elseif ($e->getResponse()->getStatusCode() == '500')
            {
                $response = json_decode($e->getResponse()->getBody(true)->getContents());
                return $response;
            }

            elseif ($e->getResponse()->getStatusCode() == '401')
            {
                $response = json_decode($e->getResponse()->getBody(true)->getContents());
                return $response;
            }

            elseif ($e->getResponse()->getStatusCode() == '403')
            {
                $response = json_decode($e->getResponse()->getBody(true)->getContents());
                return $response;
            }
            else
            {
                $response = json_decode($e->getResponse()->getBody(true)->getContents());
                return $response;
            }

        }

        public
        function get_servers()
        {
            try
            {
                $url = self::API_URL . "/server";
                $option = array('exceptions' => false);
                $header = array('Authorization'=>'Bearer ' . $this->accessToken);
                $response = $this->client->get($url, array('headers' => $header));
                $result = json_decode($response->getBody()->getContents());
                return $result;
            }

            catch (RequestException $e)
            {
                $response = $this->StatusCodeHandling($e);
                return $response;
            }

        }

        public
        function get_applications()
        {
            try
            {
                $url = self::API_URL . "/apps";
                $header = array('Authorization'=>'Bearer ' . $this->accessToken);
                $response = $this->client->get($url, array('headers' => $header));
                return json_decode($response->getBody()->getContents());
            }

            catch (RequestException $e)
            {
                $response = $this->StatusCodeHandling($e);
                return $response;
            }

        }

        public
        function AddApplication($serverid,$application,$app_version,$app_name)
        {
            try
            {
                $url = self::API_URL . "/app";
                $data = ['server_id' => $serverid,'application' => $application,'app_version' => $app_version,'app_label' => $app_name];
                $header = array('Authorization'=>'Bearer ' . $this->accessToken);
                $response = $this->client->post($url, array('query' => $data,'headers' => $header));
                return json_decode($response->getBody()->getContents());
            }

            catch (RequestException $e)
            {
                $response = $this->StatusCodeHandling($e);
                return $response;
            }

        }

        public
        function GenerateKey($serverid,$applicationid)
        {
            try
            {
                $url = self::API_URL . "/git/generateKey";
                $data = [
                    'server_id' => $serverid,
                    'app_id' => $applicationid
                ];
                $header = array('Authorization'=>'Bearer ' . $this->accessToken);
                $response = $this->client->post($url, array('query' => $data,'headers' => $header));

                $key = $this->GetKey($serverid,$applicationid);
                return $key;
            }
            catch (RequestException $e)
            {
                $response = $this->StatusCodeHandling($e);
                return $response;
            }
        }

          public
        function GetKey($serverid,$applicationid)
        {
            try
            {
                $url = self::API_URL . "/git/key";
                $data = [
                    'server_id' => $serverid,
                    'app_id' => $applicationid
                ];
                $header = array('Authorization'=>'Bearer ' . $this->accessToken);
                $response = $this->client->get($url, array('query' => $data,'headers' => $header));
                return json_decode($response->getBody()->getContents());
              }

            catch (RequestException $e)
            {
                $response = $this->StatusCodeHandling($e);
                return $response;
            }

        }

         public
        function GetBranches($serverid,$applicationid,$git_url)
        {
            try
            {
                $url = self::API_URL . "/git/branchNames";
                $data = [
                    'server_id' => $serverid,
                    'app_id' => $applicationid,
                    'git_url' => $git_url
                ];
                $header = array('Authorization'=>'Bearer ' . $this->accessToken);
                $response = $this->client->get($url, array('query' => $data,'headers' => $header));
                return json_decode($response->getBody()->getContents());

            }

            catch (RequestException $e)
            {
                $response = $this->StatusCodeHandling($e);

                return $response;
            }

        }

         public function GetClone($serverid,$applicationid,$git_url,$git_branch,$deploy_path)
        {
            try
            {
                $url = self::API_URL . "/git/clone";
                $data = [
                    'server_id' => $serverid,
                    'app_id' => $applicationid,
                    'git_url' => $git_url,
                    'branch_name' => $git_branch,
                    'deploy_path' => $deploy_path
                ];
                $header = array('Authorization'=>'Bearer ' . $this->accessToken);
                $response = $this->client->post($url, array('query' => $data,'headers' => $header));
                return json_decode($response->getBody()->getContents());
            }

            catch (RequestException $e)
            {
                $response = $this->StatusCodeHandling($e);

                return $response;
            }

        }

          public function Getpull($serverid,$applicationid,$git_url,$git_branch,$deploy_path)
        {
            try
            {
                $url = self::API_URL . "/git/pull";
                $data = [
                    'server_id' => $serverid,
                    'app_id' => $applicationid,
                    'git_url' => $git_url,
                    'branch_name' => $git_branch,
                    'deploy_path' => $deploy_path
                ];
                $header = array('Authorization'=>'Bearer ' . $this->accessToken);
                $response = $this->client->post($url, array('query' => $data,'headers' => $header));
                return json_decode($response->getBody()->getContents());
            }

            catch (RequestException $e)
            {
                $response = $this->StatusCodeHandling($e);

                return $response;
            }

        }
}
