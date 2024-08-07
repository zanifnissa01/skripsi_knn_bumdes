<?php

namespace Rllyhz\Dev\KNN;

class Data {
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var float
     */
    private $jarakHasil;

    /**
     * Constructor.
     *
     * @param array $data
     */
    function __construct(array $data)
    {
        $this->data = $data;
        $this->jarakHasil = 1.0; // Menggunakan float
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $namaParameter
     * @return mixed|null
     */
    public function get($namaParameter)
    {
        return $this->data[$namaParameter] ?? null;
    }

    /**
     * @param float $jarakHasil
     * @return $this
     */
    public function setJarakHasil(float $jarakHasil)
    {
        $this->jarakHasil = $jarakHasil;

        return $this;
    }

    /**
     * @return float
     */
    public function getJarakHasil()
    {
        return $this->jarakHasil;
    }
}
