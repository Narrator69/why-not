<?

	class Engine {

		private $table = 'News';
		private $data = [];
		
		private function error($message){
			echo $message;
			die;
		}

		public function getNews($params = []){
			$api = new API;
			$this->data['response'] = $api->newsGet($params);
		}

		public function parseNews() {
			$array = json_decode($this->data['response'], true);
			for ($i = 1; $i < 200; $i++) { // 200 - is maximal count for news
				$ownerID = $array["response"][$i]["owner_id"];
				$postID = $array["response"][$i]["id"];
				$postType = $array["response"][$i]["post_type"];

				if ($ownerID < 0 && $postType == "post") { // check for owner type and post type
					$positiveOwnerID = abs($ownerID); // Negative to positive
					$this->data['news'][$positiveOwnerID] = $postID;
					//echo '<a href="http://vk.com/wall' . $ownerID . '_' . $postID . '">vk.com/wall' . $ownerID . '_' . $postID . '</a><br/>';
				}
			}

			//var_dump ($this->data['news']);
		}

		public function checkPublics() {
			$api = new API;
			foreach ($this->data['news'] as $key => $value) {
				$query = $api->publicIsMember([$key, BOTID]);
				$response = json_decode($query, true);
				if ($response['response'] == 0) { // If all right
					$this->data['actualNews'][$key] = $value;
				}
			}
		}

		public function joinPublics() {
			$api = new API;
			foreach ($this->data['actualNews'] as $key => $value) {
				$query = $api->publicJoin($key);
				$response = json_decode($query, true);
				if ($response['response'] == 1) {
					$this->engineNews([$key, $value]);
				}
			}
		}

		public function engineNews($params = []) {
			echo 'ok'; die;
			if (!$params || gettype($params) != 'array') {
				self::error('Ошибка: repostInsertNews');
				return;
			}

			$api = new API;
			$query = $api->newsRepost(['-' . $params[0], $params[1]]);
			$response = json_decode($query, true);

			if ($response['response'][0]['success'] == 1) {
				$db = new DataBase();

				$sql = 'INSERT INTO ' . $this->table . ' (Owner, Post) VALUES (' . $params[0] . ', ' . $params[1] . ')';
				return $db->execute($sql);
			}
		}

		public function insertNews() {
			$db = new DataBase();
			//$db->setClassName(get_called_class());
			$news = [];
			foreach ($this->data['news'] as $key => $value) {
				$news[] = '(' . $key . ', ' . $value . ')';
			}
			$sql = 'INSERT INTO ' . $this->table . '(Owner, Post) VALUES ' . implode(', ', array_values($news)) . ' ON DUPLICATE KEY UPDATE Owner = Owner';
			return $db->execute($sql);
		}
	}
?>