<?php namespace Argentum88\Phad\Columns;

use Phalcon\Mvc\Model\Resultset as Collection;
use Phalcon\Mvc\Model\Query\Builder;
use Argentum88\Phad\BaseRepository;

abstract class NamedColumn extends BaseColumn
{

	/**
	 * Column field name
	 * @var string
	 */
	protected $name;

	/**
	 * @param $name
	 */
	function __construct($name)
	{
		parent::__construct();

		$this->name($name);
	}

	/**
	 * Get or set column field name
	 * @param string|null $name
	 * @return $this|string
	 */
	public function name($name = null)
	{
		if (is_null($name))
		{
			return $this->name;
		}
		$this->name = $name;
		return $this;
	}

	/**
	 * Get column value from instance
	 * @param mixed $instance
	 * @param string $name
	 * @return mixed
	 */
	protected function getValue($instance, $name)
	{
		$parts = explode('.', $name);
		$part = array_shift($parts);
		if ($instance instanceof Collection)
		{

		} else
		{
			$instance = $instance->{$part};
		}
		if ( ! empty($parts) && ! is_null($instance))
		{
			return $this->getValue($instance, implode('.', $parts));
		}
		return $instance;
	}

    /**
     * @param BaseRepository $repository
     * @param Builder $query
     * @param string $orderDirection
     */
    public function order($repository, $query, $orderDirection)
    {
        $name = $this->name();
        if ($repository->hasColumn($name)) {

            $query->orderBy($query->getFrom() . ".$name $orderDirection");
        } else {

            $query->orderBy("$name $orderDirection");
        }
    }

}