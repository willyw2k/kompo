<?php 

namespace Kompo\Elements\Traits;

trait HasClasses 
{
    /**
     * The element's classes string.
     *
     * @var array
     */
    public $class = '';

    /**
     * Adds classes to the element.
     *
     * @param  string  $classes
     * @return mixed
     */
    public function addClass($classes)
    {
        return $this->class($this->class ? 
            ($this->class.' '.trim($classes)) :
            $classes
        );
    }

    /**
     * Sets the class attribute of the element.
     * For multiple classes, use a space-separated string.
     *
     * @param  string  $classes The class attribute.
     * @return mixed
     */
    public function class($classes = null)
    {
        if($classes){
            $this->class = trim($classes);
            return $this;
        }else{
            return $this->class;
        }
    }

    /**
     * Sets the class attribute for the input element of the field.
     * For multiple classes, use a space-separated string.
     *
     * @param  string  $classes The class attribute.
     * @return mixed
     */
    public function inputClass($classes)
    {        
        return $this->data(['inputClass' => $classes]);
    }

    /**
     * Sets a specific col value when the element is used inside `Columns`. By default, the columns get equal widths. A 12 column grid system is used here (same as Bootstrap CSS). For example:
     * <php>Columns::form(
     *    Html::form('Column 1')->col('col-8'),
     *    Html::form('Column 2')->col('col-4')
     * )</php>
     *
     * @param      string  $col    The col attribute. Ex: `col-8`.
     *
     * @return self 
     */
    public function col($col)
    {
        return $this->data(['col' => $col]);
    }
}