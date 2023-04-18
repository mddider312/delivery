<?php

namespace App\Models;

use CodeIgniter\Model;

class Shipment extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'shipments';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
        "reference_id",
        "service_level",
        "shipment_no",
        "shipment_group",
        "driver",
        "delivery_partner",
        "driver_commission",
        "delivery_partner_commission",
        "status",
        "shipment_status",
        "origin",
        "destination",
        "location",
        "lat",
        "lng",
        "size",
        "weight",
        "declaration_value",
        "quantity",
        "receiver_name",
        "receiver_phone",
        "receiver_telephone",
        "receiver_email",
        "receiver_address",
        "receiver_address_type",
        "receiver_address_line1",
        "receiver_address_line2",
        "receiver_city",
        "receiver_state",
        "receiver_country",
        "receiver_postcode",
        "sender_name",
        "sender_email",
        "sender_phone",
        "sender_address_line1",
        "sender_address_line2",
        "sender_state",
        "sender_city",
        "sender_country",
        "sender_postcode",
        "comment",
        "metadata",
        "group_id",
        "master_id",
        "file_reference_id",
        "container",
        "container_reference_id",
        "client",
        "estimated_time_of_arrival",
        "estimated_time_of_departure",
        "pickup_date",
        "payable_by",
        "instructions",
        "description",
        "volume",
        "partner",
        "partner_reference_id",
        "delivery_attempts",
        "charges",
        "charges_currency",
        "goods_sku",
        "goods_value",
        "goods_value_currency",
        "port_code",
        "mother_bag",
        "awb_no",
        "biz_key",
        "user_updated_at",
        "created_at",
        "updated_at",
        "created_by",
        "updated_by",
        "deleted_at",
	];
}
