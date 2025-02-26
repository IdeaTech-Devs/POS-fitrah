	<?php

	defined('BASEPATH') || exit('No direct script access allowed');

	class Model_product_unit extends CI_Model
	{
		public $table         = 'units';
		public $column_order  = ['unit_id'];
		public $column_search = [null];
		public $order         = ['unit_id' => 'desc'];

		public function get_unit_datatables()
		{
			$this->_get_datatables_query();
			if ($_POST['length'] !== -1) {
				$this->db->limit($_POST['length'], $_POST['start']);
				$query = $this->db->get();

				return $query->result();
			}
		}

		private function _get_datatables_query()
		{
			$this->db->from($this->table);
			$i = 0;

			foreach ($this->column_search as $item) {
				if ($_POST['search']['value']) {
					if ($i === 0) {
						$this->db->group_start();
						$this->db->like($item, $_POST['search']['value']);
					} else {
						$this->db->or_like($item, $_POST['search']['value']);
					}
					if (count($this->column_search) - 1 === $i) {
						$this->db->group_end();
					}
				}
				$i++;
			}
			if (isset($_POST['order'])) {
				$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} elseif (isset($this->order)) {
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}

		public function count_filtered()
		{
			$this->_get_datatables_query();
			$query = $this->db->get();

			return $query->num_rows();
		}

		public function count_all()
		{
			$this->db->from($this->table);

			return $this->db->count_all_results();
		}

		public function find_unit($unit_id)
		{
			$this->db->from($this->table);
			$this->db->where('unit_id', $unit_id);

			return $this->db->get()->row();
		}

		public function find_units()
		{
			$this->db->select('unit_id, unit');

			return $this->db->get($this->table)->result();
		}

		public function save_unit($data)
		{
			return $this->db->insert($this->table, $data);
		}

		public function update_unit($unit_id, $data)
		{
			$this->db->where('unit_id', $unit_id);

			return $this->db->update($this->table, $data);
		}

		public function delete_unit($id) {
			$this->db->where('unit_id', $id);
			$this->db->delete($this->table);
		}
	}
