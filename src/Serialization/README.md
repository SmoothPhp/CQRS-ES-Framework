Serialization
==========

The Smooth PHP CQRS ES framework comes with a simple serializer, designed to get you started as quickly as possible. Usage of the serializer will allow you to quick convert complex DTO's to simple associative arrays.
  
### Examples
```php
<?php
namespace App;
use SmoothPhp\Contracts\Serialization\Serializable;

class MyDTO implements Serializable {
	public function __construct(Id $id, DateTime $creationDate) {
		$this->id = $id;
		$this-creationDate = $creationDate;
	}

	// getters

	public function serialize()
	{
		return [
			'id'   => (string) $this->id,
			'date' => $this->creationDate->serialize(),
		];
	}

	public static function deserialize(array $data)
	{
		return new static(
			new Id($data['id']),
			DateTime::deserialize($data['date'])
		);
	}
}

$dto = new App\MyDTO(new App\Id(uuid()), App\DateTime::now());

$serializer = new \SmoothPhp\Serialization\ObjectSelfSerializer;

// Store in database, job queue, etc
$serialized = $serializer->serialize($dto);

// Use in app
$object = $serializer->deserialize($serialized);
```