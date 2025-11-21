<?php

class Bill
{
    protected $id;
    protected $created;
    protected $updated;
    protected $bill_date;
    protected $from_date;
    protected $to_date;
    protected $unit;
    protected $price;

    public function __construct($rec = null)
    {
        $this->id = (array_key_exists("id", $rec) && $rec['id'] !== NULL) ? $rec['id'] : -1;
        $this->created = (array_key_exists("created", $rec) && $rec['created'] !== NULL) ? $rec['created'] : null;
        $this->updated = (array_key_exists("updated", $rec) && $rec['updated'] !== NULL) ? $rec['updated'] : null;
        $this->bill_date = (array_key_exists("bill_date", $rec) && $rec['bill_date'] !== NULL) ? $rec['bill_date'] : null;
        $this->from_date = (array_key_exists("from_date", $rec) && $rec['from_date'] !== NULL) ? $rec['from_date'] : null;
        $this->to_date = (array_key_exists("to_date", $rec) && $rec['to_date'] !== NULL) ? $rec['to_date'] : null;
        $this->unit = (array_key_exists("unit", $rec) && $rec['unit'] !== NULL) ? $rec['unit'] : null;
        $this->price = (array_key_exists("price", $rec) && $rec['price'] !== NULL) ? $rec['price'] : null;
    }

    public static function fromPost($post)
    {
        $rec1['id'] = !empty($post['bill_id']) ? $post['bill_id'] : -1;
        $rec1['bill_date'] = $post['bill_bill_date'];
        $rec1['from_date'] = $post['bill_from_date'];
        $rec1['to_date'] = $post['bill_to_date'];
        $rec1['unit'] = $post['bill_unit'];
        $rec1['price'] = $post['bill_price'];
        $new = new static($rec1);
        return $new;
    }

    public static function fromDatabase($db)
    {
        $rec1['id'] = $db['id'];
        $rec1['created'] = $db['created'];
        $rec1['updated'] = $db['updated'];
        $rec1['bill_date'] = $db['bill_date'];
        $rec1['from_date'] = $db['from_date'];
        $rec1['to_date'] = $db['to_date'];
        $rec1['unit'] = $db['unit'];
        $rec1['price'] = $db['price'];
        $new = new static($rec1);
        return $new;
    }

    public function id()
    {
        return intval($this->id);
    }
    public function created()
    {
        return $this->created;
    }
    public function updated()
    {
        return $this->updated;
    }
    public function bill_date()
    {
        return $this->bill_date;
    }
    public function from_date()
    {
        return $this->from_date;
    }
    public function to_date()
    {
        return $this->to_date;
    }
    public function unit()
    {
        return $this->unit;
    }
    public function price()
    {
        return ($this->price === NULL) ? null : floatval($this->price);
    }

    public function toString($pretty = false)
    {
        $obj = (object) [
            "id" => $this->id(),
            "created" => $this->created(),
            "updated" => $this->updated(),
            "bill_date" => $this->bill_date(),
            "from_date" => $this->from_date(),
            "to_date" => $this->to_date(),
            "unit" => $this->unit(),
            "price" => $this->price()
        ];

        if ($pretty === true)
            return json_encode(get_object_vars($obj), JSON_PRETTY_PRINT);

        return json_encode(get_object_vars($obj));
    }
}
