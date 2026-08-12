<?php

require_once __DIR__ . '/../Core/Database.php';

class TrnUnit
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Ambil semua transaksi, JOIN ke mst_unit & employee
     * supaya nama unit dan nama sales ikut ditampilkan (bukan cuma kode/id).
     */
    public function getAll(): array
    {
        $sql = 'SELECT
                    t.trn_unit_code,
                    t.price,
                    t.qty,
                    t.customer,
                    t.date,
                    t.employee_id,
                    e.name AS sales_name,
                    t.mst_unit_code,
                    u.name AS unit_name
                FROM trn_unit t
                JOIN mst_unit u ON u.mst_unit_code = t.mst_unit_code
                JOIN "Employee" e ON e.employee_id = t.employee_id
                ORDER BY t.date DESC';

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function findByCode(string $code): array|false
    {
        $sql = 'SELECT trn_unit_code, price, qty, customer, date, employee_id, mst_unit_code
                FROM trn_unit
                WHERE trn_unit_code = :code';

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['code' => $code]);

        return $stmt->fetch();
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO trn_unit
                    (trn_unit_code, price, qty, customer, employee_id, date, mst_unit_code)
                VALUES
                    (:trn_unit_code, :price, :qty, :customer, :employee_id, :date, :mst_unit_code)';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'trn_unit_code' => $data['trn_unit_code'],
            'price'         => $data['price'],
            'qty'           => $data['qty'],
            'customer'      => $data['customer'],
            'employee_id'   => $data['employee_id'],
            'date'          => $data['date'],
            'mst_unit_code' => $data['mst_unit_code'],
        ]);
    }

    public function update(string $code, array $data): bool
    {
        $sql = 'UPDATE trn_unit
                SET price = :price,
                    qty = :qty,
                    customer = :customer,
                    employee_id = :employee_id,
                    date = :date,
                    mst_unit_code = :mst_unit_code
                WHERE trn_unit_code = :code';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'price'         => $data['price'],
            'qty'           => $data['qty'],
            'customer'      => $data['customer'],
            'employee_id'   => $data['employee_id'],
            'date'          => $data['date'],
            'mst_unit_code' => $data['mst_unit_code'],
            'code'          => $code,
        ]);
    }

    public function delete(string $code): bool
    {
        $sql = 'DELETE FROM trn_unit WHERE trn_unit_code = :code';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute(['code' => $code]);
    }

    public function isCodeExists(string $code): bool
    {
        $sql = 'SELECT 1 FROM trn_unit WHERE trn_unit_code = :code';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['code' => $code]);

        return (bool) $stmt->fetchColumn();
    }
}
