<?php

namespace App\Platform\Response;

class ListPageResponseData extends PageResponseData {
	public function setPaginate($value) {
		$this->paginate = $value;
		return $this;
	}
}