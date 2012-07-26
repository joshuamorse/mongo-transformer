MongoTransformer
================

A utility class that transforms MongoDB cursor objects to various other types.

Usage examples:
	- $transformer->convert($mongoCursor)->toArray();
	- $transformer->convert($mongoCursor)->toJson();
	- $transformer->convert($mongoCursor)->toJsonp($callback);
