<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 12/24/2017
 * Time: 5:08 PM
 */

namespace SphereMall\Elastic\Search\Elements;

/**
 * Class SearchElement
 * @package SphereMall\Elastic\Search\Elements
 */
abstract class SearchElement
{
    #region [Properties]
    const FILTER = 'filter';
    const MUST = 'must';

    protected $values;
    protected $name;
    protected $fieldName;
    #endregion

    #region [Constructor]
    /**
     * SearchElement constructor.
     * @param $name
     * @param $values
     */
    public function __construct($values, $name = "")
    {
        $this->name = $name;
        $this->values = $values;
    }
    #endregion

    #region [Public methods]
    /**
     * @return array
     * @throws \Exception
     */
    public function getQueryParams()
    {
        if (empty($this->values)) {
            return [];
        }

        return $this->getQueryParamsWithValues();
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }
    #endregion

    #region [Abstract methods]
    abstract public function getType();
    #endregion

    #region [Protected methods]
    /**
     * @return array
     * @throws \Exception
     */
    protected function getQueryParamsWithValues(): array
    {
        if (!is_array($this->values)) {
            return $this->getParamsFromConfig($this->values);
        }

        return array_map(function ($value) {
            return $this->getParamsFromConfig($value);
        }, $this->values);
    }

    /**
     * @param $value
     * @return array
     * @throws \Exception
     */
    protected function getParamsFromConfig($value)
    {
        $fileName = $this->getConfigFileName();

        $json = str_replace("__VALUE__", $value, file_get_contents($fileName));
        $json = str_replace("__NAME__", $this->name, $json);

        return json_decode($json, true);
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function getConfigFileName(): string
    {
        $elementName = ucfirst((new \ReflectionClass(get_called_class()))->getShortName());
        $fileName = __DIR__ . "/../../../configs/search/$elementName.json";
        if (!file_exists($fileName)) {
            throw new \Exception("JSON configuration file was not found for [{$elementName}]");
        }

        return $fileName;
    }
    #endregion
}