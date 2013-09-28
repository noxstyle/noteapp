<?php

namespace app\models;

/**
 * This is the model class for table "note".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $active
 * @property string $insert_time
 * @property string $update_time
 *
 * @property NoteTag[] $noteTags
 */
class Note extends \yii\db\ActiveRecord
{
	protected $updateableColumns = array('title', 'content', 'active');

	/**
	 * @var Array custom attributes that should be JSON encodable
	 */
	public $customAttributes = array(
		'tags' => 'getTags',
	);

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'note';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return array(
			array('content', 'string'),
			array('insert_time, update_time, active', 'safe'),
			array('title', 'string', 'max' => 128)
		);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'content' => 'Content',
			'active' => 'Active',
			'insert_time' => 'Insert Time',
			'update_time' => 'Update Time',
		);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getNoteTags()
	{
		return $this->hasMany('NoteTag', array('note_id' => 'id'));
	}

	/**
	 * Return Modes:
	 * 0 - default, returns an array holding Tag objects
	 * 1 - toArray, returns an array of Tag names, e.g. array("tag1", "tag2")
	 * 2 - toString, returns tags as a string using separator defined in Tag::TAG_DELIMITER, e.g. "tag1, tag2"
	 * 
	 * @param Bool $returnMode
	 * @return Mixed
	 */
	public function getTags($returnMode=0)
	{
		$tags = array();
		foreach ($this->noteTags as $link)
			$tags[] = Tag::findById($link['tag_id']);

		// Return empty if tags not found
		if (empty($tags))
			return ($returnMode == 2) ? null : array();

		if ($returnMode == 1 OR $returnMode == 2)
		{
			foreach ($tags as $tag)
				$tagArr[] = $tag->name;

			$tags = $tagArr;
		}

		if ($returnMode === 2)
			return implode(Tag::TAG_DELIMITER, $tags);

		return $tags;
	}

	/**
	 * Extends AR's default beforeSave() method in order to set timestamps automatically 
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		$date = date('Y-m-d H:i:s');
		if ($this->getIsNewRecord())
			$this->insert_time = $date;
		else
			$this->update_time = $date;

		return parent::beforeSave($insert);
	}

	/**
	 * Retrieves all notes stored in db
	 * @param Bool $toArray wether the data should be mapped to array instead of Note object
	 * @return Array
	 */
	public static function getAll($toArray=false)
	{
		$notes = static::find()->all();
		
		if (!$toArray)
			return $notes;

		$noteArr = array();
		foreach ($notes as $note)
		{
			$attrs = $note->attributes;
			foreach ($note->customAttributes as $key => $value)
				$attrs[$key] = $note->$value(2);

			$noteArr[] = $attrs;
		}

		return $noteArr;
	}

	/**
	 * Saves Note if data (title or content) has changes
	 * @param Array $data - Json parsed array
	 * @return Bool true if entry was saved
	 */
	public function saveUpdateable($data)
	{
		if (!empty($data["tags"]))
			$tags = explode(Tag::TAG_DELIMITER, $data["tags"]);
		else
			$tags = array();

		$dataChanged = false;		
		foreach ($this->updateableColumns as $column)
		{
			if ($this->$column != $data[$column])
			{
				$this->$column = $data[$column];
				$dataChanged = true;
			}
		}

		# Update / Insert tags
		if ($this->getIsNewRecord())
		{
			$this->save();

			foreach ($tags as $tag)
				$this->linkTag($tag);

			return true;
		}
		else
		{
			$tagsUpdated = $this->updateTags($tags);
		
			if ($dataChanged OR $tagsUpdated)
			{
				$this->save();
				return true;
			}
		}

		return false;
	}

	/**
	 * @param Array $tags
	 * @return Bool update status, true for changed tag values
	 */
	public function updateTags($tags)
	{
		$oldTags = $this->getTags(1);

		$oldTagsLarger = count($oldTags) > count($tags);
		$diff = array_diff($oldTagsLarger ? $oldTags : $tags, $oldTagsLarger ? $tags : $oldTags);

		if (!empty($diff))
		{
			foreach ($diff as $value)
			{
				if (in_array($value, $oldTags))
					$this->unlinkTag($value);
				else
					$this->linkTag($value);
			}
			return true;
		}
		return false;
	}

	/**
	 * Links tag to the note
	 * @param String $tag
	 */
	public function linkTag($tag)
	{
		if (empty($tag))
			return false;

		$tagInstance = Tag::findByName($tag);
		if (is_null($tagInstance))
			$tagInstance = Tag::createNew($tag);

		$connection = \Yii::$app->db;
		$connection->createCommand()->insert('note_tag', array(
			'note_id' 	=> $this->id, 
			'tag_id' 	=> $tagInstance->id
		))->execute();
	}

	/**
	 * Unlinks tag from Note
	 * @param String|Int $tag
	 */
	public function unlinkTag($tag)
	{
		$tagInstance = Tag::findByName($tag);
		if (empty($tag) OR is_null($tagInstance))
			return false;

		$connection = \Yii::$app->db;
		$connection->createCommand()->delete('note_tag', "tag_id = {$tagInstance->id} AND note_id = {$this->id}")->execute();
	}

	public static function reorder($notes, $noteData)
	{
		foreach ($noteData as $data)
		{

			# code...
		}
		return $notes;
	}
}
