<?php
class Site_model extends CI_Model{
	


	function __construct()
	{
		parent::__construct();
	}


	function build_grid_for_public()
	{
		$sql = "
					SELECT
					u.id AS userid,
					u.username,
					u2w.want_id,
					w.title,
					w.price,
					w.description,
					w.preview_image,
					uav.avatar_image_url
					FROM users u
					LEFT JOIN
					user2wants u2w ON
					u2w.user_id = u.id
					LEFT JOIN
					wanted w ON
					w.id = u2w.want_id
					LEFT JOIN
					user_avatars uav ON
					u2w.user_id = uav.user_id			
			";
		$sql = "
					SELECT
					u.id AS userid,
					u.username,
					u2w.want_id,
					w.title,
					w.price,
					w.description,
					w.preview_image,
					uav.avatar_image_url
					FROM wanted w
					LEFT JOIN
					user2wants u2w ON
					u2w.want_id = w.id
					LEFT JOIN
					users u ON
					u.id = u2w.user_id
					LEFT JOIN
					user_avatars uav ON
					u.id = uav.user_id			
			";
		$q= $this->db->query($sql);

		if($q->num_rows() > 0)
		{
			foreach ((array)$q->result() as $row)
			{
				$data[] = (array)$row;
			}
			return $data;
		}
		else
		{
			return false;
		}
	}
	
	function build_grid_for_user($user_id)
	{

		$stmt = db_read()->prepare(
				"
					SELECT
					u.id AS userid,
					u.username,
					u2w.want_id,
					w.title,
					w.price,
					w.description,
					w.preview_image,
					uav.avatar_image_url
					FROM users u
					LEFT JOIN
					user2wants u2w ON
					u2w.user_id = u.id
					LEFT JOIN
					wanted w ON
					w.id = u2w.want_id
					LEFT JOIN
					user_avatars uav ON
					u2w.user_id = uav.user_id
					WHERE u.id = :user_id
				"
		);
		$stmt->bindParam(':user_id', $user_id);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $results;
	}
	
	function list_trade_services_for_user($user_id)
	{

		$stmt = db_read()->prepare(
				"
					SELECT
					*
					FROM user2services u2s
					LEFT JOIN
					services s ON
					u2s.service_id = s.id
					WHERE u2s.user_id = :user_id
				"
		);
		$stmt->bindParam(':user_id', $user_id);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $results;	
	}
	
	function add_wish_item_manually($data)
	{
		$stmt = db_write()->prepare(
				"
					INSERT tradebook.wanted
					SET
						title=:title
						,price=:price
						,description=:description
						,preview_image=:preview_image
				"
		);
		$stmt->bindParam(':title', $data['itemTitle']);
		$stmt->bindParam(':price', $data['itemPrice']);
		$stmt->bindParam(':description', $data['itemDescription']);
		$stmt->bindParam(':preview_image', $data['itemImage']);
		$stmt->execute();
		return (bool) $stmt->rowCount();	
	}
	
	function CURL($url, $post = null, $retries = 3)
	{
		$curl = curl_init($url);
		if (is_resource($curl) === true)
		{
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_ENCODING, 1);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept-Encoding: gzip,deflate'));
			if (null != $post)
			{
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, (is_array($post) === true) ? http_build_query($post, '', '&') : $post);
			}
			$result = false;
			while (($result === false) && (--$retries > 0))
			{
				$result = curl_exec($curl);
				$response = curl_getinfo($curl);
			}
			curl_close($curl);
		}
		switch ($response['http_code'])
		{
			case 200:
				$return = array(
					'response' => $response,
					'output' => htmlspecialchars($result, ENT_QUOTES)
				);
				break;
			case 301:
			case 302:
				foreach (get_headers($response['url']) as $value)
				{
					if (substr(strtolower($value), 0, 9) == "location:")
					{
						return self::CURL(trim(substr($value, 9, strlen($value))));
					}
				}
				break;
			default:
				$return = false;
				break;
		}
		return $return;
	}

	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || $is_logged_in !==true)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function signupFormArray()
	{
		$inputs = array(
	
			'first_name' => 'text',
			'last_name' => 'text',
			'email_address' => 'text',
			'username' => 'text',
			'password1' => 'password',
			'password2' => 'password'
		);
//		$data = array('first');
		
		foreach ($inputs as $key => $value)
		{			
			$data[] = array(
					'name'		=> $key,
					'id'		=> $key,
					'type'		=> $value
				);			
		}
		return $data;
	}
	
	function updateSession($data)
	{
		$this->load->model('membership_model');
		
		if (!array_key_exists('user_id', $data['user_info'])) 
		{
			$data['user_info']['user_id']= $this->membership_model->currentUserId();
		}
		if (!array_key_exists('username', $data['user_info'])) 
		{
			$data['user_info']['username']= $this->membership_model->currentUsername();
		}
		if (!array_key_exists('first_name', $data['user_info'])) 
		{
			$data['user_info']['first_name']= $this->membership_model->currentUserFirstName();
		}
		if (!array_key_exists('last_name', $data['user_info'])) 
		{
			$data['user_info']['last_name']= $this->membership_model->currentUserLastName();
		}
		if (!array_key_exists('email_address', $data['user_info'])) 
		{
			$data['user_info']['email_address']= $this->membership_model->currentUserEmailAddress();
		}

		$this->session->set_userdata($data);
	}
	
	function getFullTradeServiceList()
	{
		$this->db->select('*');
		$this->db->from('services');
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
		
	}
	
	function getAvatarURL($userid, $size)
	{
		$sql = "
			SELECT
			email
			FROM users
			WHERE id= :userid
			";
		$query = $this->db->get_where('users', array('id' => $userid));
		$results = $query->result_array();
		$return = 'http://www.gravatar.com/avatar/'.md5($results[0]['email_address']).'?s='.$size;
		return $return;
		
	}
	
	function processItemImage($srcPath, $library='gd2', $newName, $newPath, $width, $height)
	{
		$config['image_library']	= 'gd2';
		$config['source_image']		= $srcPath;
		$config['create_thumb']		= TRUE;
		$config['maintain_ratio']	= TRUE;
		$config['width']			= $width;
		$config['height']			= $height;
		$config['new_image']		= '/images/processed_image.jpg';
		$this->load->library('image_lib');		
		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		$this->image_lib->crop(); 
//		$resize = $this->image_lib->resize();
//		return $resize;
	}
}
//echo "model_loaded";