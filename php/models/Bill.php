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
        $this->id = !empty($rec['id']) ? $rec['id'] : -1;
        $this->created = !empty($rec['created']) ? $rec['created'] : null;
        $this->updated = !empty($rec['updated']) ? $rec['updated'] : null;
        $this->bill_date = !empty($rec['bill_date']) ? $rec['bill_date'] : null;
        $this->from_date = !empty($rec['from_date']) ? $rec['from_date'] : null;
        $this->to_date = !empty($rec['to_date']) ? $rec['to_date'] : null;
        $this->unit = !empty($rec['unit']) ? floatval($rec['unit']) : null;
        $this->price = !empty($rec['price']) ? floatval($rec['price']) : null;
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
        return $this->price;
    }

    public function toString($pretty = false)
    {
        if ($pretty === true)
            return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);

        return json_encode(get_object_vars($this));
    }
}
