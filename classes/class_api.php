<?
	class API 
		extends Abstract_API {
		
			public function newsGet ($params = []){
				if (!$params || gettype($params) != 'array') {
					self::error('Ошибка: newsGet');
					return;
				}

				$query = ['newsfeed.search', 'q=' . $params[0]];

				if ($params[1]) {
					$query[1] .= '&count=' . $params[1];
				}
				return self::returnExecute($query, false);
			}
			
			public function newsRepost ($params = []){
				if (!$params || gettype($params) != 'array') {
					self::error('Ошибка: newsRepost');
					return;
				}
				$query = ['wall.repost', 'object=wall' . $params[0] . '_' . $params[1]];
				return self::returnExecute($query);
			}
			
			public function newsDelete ($params = ''){
				if (!$params || gettype($params) != 'string') {
					self::error('Ошибка: newsDelete');
					return;
				}
				$query = ['wall.delete', 'post_id=' . $params];
				return self::returnExecute($query);
			}
			
			public function publicJoin ($params){
				/*
				if (!$params || gettype($params) != 'integer') {
					self::error('Ошибка: publicJoin');
					return;
				}
				*/
				$query = ['groups.join', 'group_id=' . $params];
				return self::returnExecute($query);
			}
			
			public function publicLeave ($params = ''){
				if (!$params || gettype($params) != 'string') {
					self::error('Ошибка: publicLeave');
					return;
				}
				$query = ['groups.leave', 'group_id=' . $params];
				return self::returnExecute($query);
			}
			
			public function publicIsMember ($params = []){
				if (!$params || gettype($params) != 'array') {
					self::error('Ошибка: publicIsMember');
					return;
				}
				$query = ['groups.isMember', 'group_id=' . $params[0] . '&user_id=' . $params[1]];
				return self::returnExecute($query, false);
			}
			
			public function messageSend ($params = []){
				if (!$params || gettype($params) != 'array') {
					self::error('Ошибка: messageSend');
					return;
				}
				$query = ['messages.send', 'user_id=' . $params[0] . '&message=' . $params[1]];
				return self::returnExecute($query);
			}
	}
?>