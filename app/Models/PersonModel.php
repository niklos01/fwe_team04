<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonModel extends Model
{
    public function getPersonen($person_id = null): ?array
    {
        $builder = $this->db->table('personen');
        $builder->select('*');

        if ($person_id !== null) {
            $builder->where('id', $person_id);
            return $builder->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }



}
