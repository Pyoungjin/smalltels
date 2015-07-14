<?php

namespace App\Http\controllers\Foundation;

use App\Model\Tels_list;
use Illuminate\Http\Request;


trait Tels_listTrait
{
    public function insertTels(array $data)
    {
        return Tels_list::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone']
        ]);
    }

    /**
     * 나중에 실험 해봐야됨.
     * @param  int    $tels_list_id [description]
     * @param  string $address      [description]
     * @return [type]               [description]
     */
    public function updateTelsAddress($tels_list_id, $address)
    {
        $tmp_tels = Tels_list::find($tels_list_id);
        $tmp_tels->address = $address;
        return $tmp_tels->save();
    }
}
