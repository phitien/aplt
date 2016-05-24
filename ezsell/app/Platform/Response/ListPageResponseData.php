<?php

namespace App\Platform\Response;

class ListPageResponseData extends ResponseData {
	public function setPaginate($value) {
		$this->paginate = $value;
		return $this;
	}
}