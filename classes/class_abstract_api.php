<? 
	abstract class Abstract_API {

		public function returnExecute ($params = [], $auth = true){
			if (!$params || gettype($params) != 'array') {
				$this->message('Ошибка: returnExecute');
				return;
			}
			
			$query = 'https://api.vk.com/method/' . $params[0] . '?' . $params[1];
			
			if ($auth) {
				$query .= '&access_token=' . TOKEN;
			}

			return file_get_contents($query);
		}

		public function error ($message = ''){
			echo $message;
			die;
		}
	}
?>