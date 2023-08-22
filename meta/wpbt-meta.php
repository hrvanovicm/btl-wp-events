<?php

interface WPBTMeta {
	static function add();
	static function html($post);
	static function rest();
	static function save($postId);
}