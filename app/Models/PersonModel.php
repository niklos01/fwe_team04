<?php
namespace App\Models;

use CodeIgniter\Model;

class PersonModel extends Model
{
    protected $table = 'personen';

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

    public function crud(string $todo, array $data = [])
    {
        switch ($todo) {

            case 'read':
                if (isset($data['id'])) {
                    $person = $this->find($data['id']);
                    return $person ?: ['status' => 'error', 'message' => 'Nicht gefunden'];
                }
                return $this->findAll();

            case 'create':
                $required_fields = ['vorname', 'nachname', 'plz', 'ort', 'username'];

                foreach ($required_fields as $field) {
                    if (! isset($data[$field]) || empty($data[$field])) {
                        return ['status' => 'error', 'message' => "$field ist erforderlich"];
                    }
                }

                if ($this->insert($data)) {
                    return ['status' => 'success', 'message' => 'Person erstellt', 'data' => $data];
                }

                return ['status' => 'error', 'errors' => $this->errors()];

            case 'update':
                if (! isset($data['id'])) {
                    return ['status' => 'error', 'message' => 'ID fehlt'];
                }
                $id = $data['id'];
                unset($data['id']);
                if ($this->update($id, $data)) {
                    return ['status' => 'success', 'message' => 'Person aktualisiert', 'id' => $id];
                }
                return ['status' => 'error', 'errors' => $this->errors()];

            case 'delete':
                if (! isset($data['id'])) {
                    return ['status' => 'error', 'message' => 'ID fehlt'];
                }
                if ($this->delete($data['id'])) {
                    return ['status' => 'success', 'message' => 'Person gelöscht'];
                }
                return ['status' => 'error', 'message' => 'Löschen fehlgeschlagen'];

            default:
                return ['status' => 'error', 'message' => 'Ungültige Aktion'];
        }
    }
}
