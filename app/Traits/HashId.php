<?php


namespace App\Traits;

use Hashids\Hashids;

trait HashId
{

    private function key()
    {
        return new Hashids('Techmozzo-tsak', 62);
    }

    public function encrypt($id): array
    {
        $data = ['message' => 'Data id is invalid'];
        if (is_numeric($id)) {
            $data = [
                'message' => 'encryption successful',
                'data_token' => $this->key()->encode($id)
            ];
        }
        return $data;
    }

    public function decrypt($token): array
    {
        $data = ['message' => 'Data does not exist'];
        $result = $this->key()->decode($token);
        if (!empty($result)) {
            $data = ['message' => 'Data exist', 'data_id' => $result[0]];
        }
        return $data;
    }
}
