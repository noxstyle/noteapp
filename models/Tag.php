<?php

namespace app\models;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 *
 * @property NoteTag[] $noteTags
 */
class Tag extends \app\models\ActiveRecord
{
	const TAG_DELIMITER = ',';

	public $active = false;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'tag';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return array(
			array('name', 'string', 'max' => 32)
		);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
		);
	}

	/**
	 * @param String $tag
	 * @return Tag
	 */
	public function createNew($tag)
	{
		$tagInstance = new Tag;
		$tagInstance->name = $tag;
		$tagInstance->save();
		return $tagInstance;
	}

	/**
	 * Finds a Tag by its name - if not found null is returned
	 * @param String $name
	 * @return Mixed
	 */
	public static function findByName($name)
	{
		return static::find()
			->where(array('name' => $name))
			->one();
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getNoteTags()
	{
		return $this->hasMany('NoteTag', array('tag_id' => 'id'));
	}

	/**
	 * Gets all tags
	 * @param Bool $asArray=false if enabled; returns tags as column=>value pairs instead of object
	 * @return Array
	 */
	public static function getAll($asArray=false)
	{
		$tags = static::find()->all();
		if (!$asArray)
			return $tags;

		foreach ($tags as $tag)
		{
			$tagArr[] = array(
				'id' => $tag->id,
				'name' => $tag->name,
				'active' => $tag->active 
			);
		}

		return $tagArr;
	}

	/**
	 * Maps current status(es) to tags
	 * @param Array $tags Tags array passed as reference
	 * @param Array $tagData description
	 */
	public static function mapStatuses(&$tags, $tagData)
	{
		for ($i=0; $i < count($tags); $i++)
		{
			foreach ($tagData as $data)
			{
				if ($tags[$i]['id'] == $data['id'])
					$tags[$i]['active'] = $data['active'];
			 } 
		}
	}

	/**
	 * Cleans orphaned tags from db
	 * Superb method naming convention by Jonne H.
	 */
	public static function eliminateOrphans()
	{
		$connection = \Yii::$app->db;
		$connection
			->createCommand('delete from '.self::tableName().' where id not in (select tag_id from note_tag)')
			->execute();
	}
}