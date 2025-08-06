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

    public function getPersonenChunk($limit, $offset): array
    {
        $builder = $this->db->table('personen');
        $builder->select('*');
        $builder->limit($limit, $offset);
        return $builder->get()->getResultArray();
    }

    public function getTotalPersonenCount(): int
    {
        return $this->db->table('personen')->countAllResults();
    }

}
