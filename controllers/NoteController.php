<?php

namespace app\controllers;

use Yii;
use app\models\Note;
use app\models\Tag;
use yii\helpers\Json;

class NoteControllerInvalidCallException extends \Exception {}

class NoteController extends \yii\web\Controller
{
	/**
	 * Gets all notes and returns those as Json data
	 * @return Array of objects
	 */
	public function actionGetNotes()
	{
		$this->_setJsonResponse();

		# Notes
		$notes = Note::getAll(true);

		# Tags
		$tags = Tag::getAll();

		return array(
			'notes' => $notes,
			'tags' => $tags
		);
	}

	/**
	 * Saves notes passed in Json and returns updated notes as Json
	 * @return Array of objects
	 */
	public function actionSaveNotes()
	{
		$saved = false;
		$this->_setJsonResponse();
		if (!Yii::$app->request->getIsPost())
			throw new NoteControllerInvalidCallException('Invalid call... '.__METHOD__.' takes in only POST requests.');

		$noteData = Json::decode(Yii::$app->request->getPost('notes'));
		foreach ($noteData as $data)
		{
			$note = Note::find($data['id']);

			if (is_null($note))
				$note = new Note;

			$changed = $note->saveUpdateable($data);

			if ($changed)
				$saved = true;
		}

		# If there were db changes we want to remove any leftover tags...
		if ($saved)
			Tag::eliminateOrphans();

		# Tags
		$tagData = Json::decode(Yii::$app->request->getPost('tags'));
		$tags = Tag::getAll(true); # Get tag data as array

		# Map Tag statuses
		if (count($tagData) > 0)
			Tag::mapStatuses($tags, $tagData);

		# Reload Note's array
		$notes = Note::getAll(true);

		# Reorder Note array
		Note::reorder($notes, $noteData);

		return array(
			'notes' => $notes,
			'tags' => $tags
		);
	}

	/**
	 * Deletes single note from persistent storage
	 * @return Array ( deleted => true|false )
	 */
	public function actionDeleteNote()
	{
		# Accept only POST requests
		if (!Yii::$app->request->getIsPost())
			throw new NoteControllerInvalidCallException('Invalid call... '.__METHOD__.' takes in only POST requests.');

		$this->_setJsonResponse();
		$data = Json::decode(Yii::$app->request->getPost('note'));
		$note = Note::find($data['id']);

		# If note by given ID is not stored in persistent storage we can safely return true...		
		$status = true;
		if (!is_null($note))
			$status = $note->delete();

		return array(
			'deleted' => $status 
		);
	}

	/**
	 * Sets the response to Json
	 */
	protected function _setJsonResponse()
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	}

}
