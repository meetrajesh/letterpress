<?php

class model_base {

	protected static function _assign_db_row_to_obj($obj, $table_name, $val, $key='id') {
		$result = db::fetch_query('SELECT * FROM %s WHERE %s="%s"', (string)$table_name, (string)$key, $val);
		if ($result) {
			foreach ($result as $k => $v) {
				$obj->$k = $v;
			}
		}
		return $obj;
	}

}