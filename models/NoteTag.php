<?php

namespace app\models;

/**
 * This is the model class for table "note_tag".
 *
 * @property integer $id
 * @property integer $note_id
 * @property integer $tag_id
 *
 * @property Tag $tag
 * @property Note $note
 */
class NoteTag extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'note_tag';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return array(
			array('note_id, tag_id', 'integer')
		);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'note_id' => 'Note ID',
			'tag_id' => 'Tag ID',
		);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getTag()
	{
		return $this->hasOne('Tag', array('id' => 'tag_id'));
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getNote()
	{
		return $this->hasOne('Note', array('id' => 'note_id'));
	}
}
