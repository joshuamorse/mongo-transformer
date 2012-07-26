<?php

/**
 * A utility class to transform MongoDB cursor objects to
 * various other types.
 *
 * Usage examples:
 *   - $transformer->convert($mongoCursor)->toArray();
 *   - $transformer->convert($mongoCursor)->toJson();
 *   - $transformer->convert($mongoCursor)->toJsonp($callback);
 *
 * @author Joshua Morse <dashvibe@gmail.com>
 */

namespace MongoTransformer;

class MongoTransformer
{
	/**
	 * Represents a MongoCursor object.
	 * 
	 * @var MongoCursor $cursor
	 */
	protected $cursor;

	/**
	 * Preps a MongoCursor object for conversion. 
	 * 
	 * @param \MongoCursor $cursor 
	 * @access public
	 * @return MongoTransformer $this
	 */
	public function convert(\MongoCursor $cursor = null)
	{
		// Set the cursor, should it not already be set.
		if (!$cursor) {
			$this->setCursor($cursor);
		}

		$this->cursor = $cursor;

		return $this;
	}

	/**
	 * Converts a MongoDB cursor to a JSONP object.
	 * 
	 * @param \MongoCursor $cursor 
	 * @access protected
	 * @return string $toJsonp
	 */
	public function toJsonp(array $options)
	{
		$toJsonp = $options['callback'] . '(' . $this->toJson($this->cursor) . ')';

		return $toJsonp;
	}

	/**
	 * Converts a MongoDB cursor to a JSON object.
	 * 
	 * @param \MongoCursor $cursor 
	 * @access protected
	 * @return string $toJson
	 */
	public function toJson()
	{
		$toJson = json_encode($this->toArray($this->cursor));

		return $toJson;
	}

	/**
	 * Converts a MongoDB cursor to an array.
	 * 
	 * @param \MongoCursor $cursor 
	 * @access protected
	 * @return array $toArray
	 */
	public function toArray()
	{
		// If we only have a single result, we can return it.
		if ($this->cursor->count() === 1) {
			foreach ($this->cursor as $result) {
				$toArray = $result;
				break;
			}
		} else {
			// Otherwise we'll convert the iterator to an array.
			$toArray = iterator_to_array($this->cursor);
		}

		return $toArray;
	}

	/**
	 * Returns the set MongoCursor object.
	 * 
	 * @access public
	 * @return void
	 */
	public function getCursor()
	{
		return $this->cursor;
	}

	/**
	 * Sets a MongoCursor object.
	 * 
	 * @param \MongoCursor $cursor 
	 * @access public
	 */
	public function setCursor(\MongoCursor $cursor)
	{
		$this->cursor = $cursor;
	}
}
