<?php

class BillType
{
    protected $id;
    protected $created;
    protected $updated;
    protected $name;
    protected $unit;
    protected $precision;

    protected $bills;

    public function __construct($rec = null)
    {
        $this->id = !empty($rec['id']) ? $rec['id'] : -1;
        $this->created = !empty($rec['created']) ? $rec['created'] : null;
        $this->updated = !empty($rec['updated']) ? $rec['updated'] : null;
        $this->name = !empty($rec['name']) ? $rec['name'] : null;
        $this->unit = !empty($rec['unit']) ? $rec['unit'] : null;
        $this->precision = !empty($rec['precision']) ? intval($rec['precision']) : 0;
    }

    public static function fromPost($post)
    {
        $rec1['id'] = !empty($post['bill_type_id']) ? $post['bill_type_id'] : -1;
        $rec1['name'] = $post['bill_type_name'];
        $rec1['unit'] = $post['bill_type_unit'];
        $rec1['precision'] = $post['bill_type_precision'];
        $new = new static($rec1);
        return $new;
    }

    public static function fromDatabase($db)
    {
        $rec1['id'] = $db['id'];
        $rec1['created'] = $db['created'];
        $rec1['updated'] = $db['updated'];
        $rec1['name'] = $db['name'];
        $rec1['unit'] = $db['unit'];
        $rec1['precision'] = $db['precision'];
        $new = new static($rec1);
        return $new;
    }

    public function id()
    {
        return $this->id;
    }
    public function created()
    {
        return $this->created;
    }
    public function updated()
    {
        return $this->updated;
    }
    public function name()
    {
        return $this->name;
    }
    public function unit()
    {
        return $this->unit;
    }
    public function precision()
    {
        return (int)$this->precision;
    }
    public function precisionDecimals()
    {
        $num = 1;
        for ($x = 0; $x < $this->precision; $x++) {
            $num = $num / 10;
        }
        return $num;
    }
    public function formatPrecision($num)
    {
        return number_format($num, $this->precision());
    }

    public function toString($pretty = false)
    {
        if ($pretty === true)
            return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);

        return json_encode(get_object_vars($this));
    }

    //

    public function bills()
    {
        return $this->bills;
    }
    public function store_bill(Bill $rec)
    {
        if ($this->bills === null)
            $this->bills = [];
        $this->bills[$rec->id()] = $rec;
    }
    public function store_bills(array $recs)
    {
        $this->bills = [];

        foreach ($recs as $rec) {
            if (!$rec instanceof Bill)
                throw new InvalidArgumentException("Array must contain only instances of Bill");
            $this->bills[$rec->id()] = $rec;
        }
    }
}
