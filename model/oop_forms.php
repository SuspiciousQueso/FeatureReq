<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   03-31-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 03-31-2016
-->



<?php
/**
 * Object Oriented Forms.
 * This set of classes allows for the creation of full pages
 * of forms using simple objects.
 *
 * @author Khurram Khan
 * @package Forms
 */

/**
 * Interface Visual
 *
 * Implemented by all elements that need
 * to be displayed.
 * @package Form
 * @subpackage BaseObjects
 */
interface Visual {

    /**
     * Loads templates for the object implementing
     * this method.
     *
     */
    function loadTemplates();
    /**
     * Displays the object implementing this method.
     *
     */
    function display();

}

/**
 * Class Element
 *
 * The base for all of our form objects
 * @package Form
 * @subpackage BaseObjects
 * @abstract
 */
abstract class Element {

    /**
     * The name of this object
     *
     * @var String
     */
    private $name = null;
    /**
     * The parent of this object
     *
     * @var Container
     */
    private $parent = null;
    /**
     * An array of errors associated
     * with this element
     *
     * @var Array
     */
    private $errors = array();
    /**
     * Flag to determine if this object
     * has errors
     *
     * @var Boolean
     */
    private $hasErrors = false;

    /**
     * Construct this element and assign
     * a name
     *
     * @param unknown_type $name
     */
    function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Sets the parent of this element
     *
     * @param Container $parent
     */
    function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Returns the parent of this object
     *
     * @return Container
     */
    function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets the name of this element
     *
     * @param String $name
     */
    function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the name of this element
     *
     * @return String
     */
    function getName()
    {
        return $this->name;
    }

    /**
     * Determines weather this element
     * is a child of another element
     *
     * @return Boolean
     */
    function isChild()
    {
        return is_object($this->parent);
    }

    /**
     * Adds an error to this element
     *
     * @param String $error
     */
    function addError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * Returns the errors as a String list
     *
     * @return String
     */
    function getErrors()
    {
        return "<li>".implode("\n<li>", $this->errors);
    }

    /**
     * Sets the "hasErrors" flag on this
     * element and recursivly, its parent.
     *
     * @param Boolean $flag
     */
    function setErrors($flag)
    {
        $this->hasErrors = $flag;
        if ($this->isChild() && $flag)
            $this->parent->setErrors($flag);
    }

    /**
     * returns weather this container
     * has errors
     *
     * @return Boolean
     */
    function hasErrors()
    {
        return $this->hasErrors;
    }

    /**
     * Removes all errors from this element
     *
     */
    function resetErrors()
    {
        $this->hasErrors = false;
    }

    /**
     * Validates this element.
     *
     * @abstract
     * @param Mixed $value
     */
    abstract function validate($value);

}

/**
 * Class Container
 *
 * Exends the element class to create a container
 * This element can hold other elements.
 * @package Form
 * @subpackage BaseObjects
 * @abstract
 */
abstract class Container extends Element {

    /**
     * An array of children.
     *
     * @var Array
     */
    private $children = array();

    /**
     * Adds a nameless child.
     *
     * @param Element $child
     */
    private function addChild($child)
    {
        $this->children[] = $child;
    }

    /**
     * Adds an element based on its name.
     *
     * @param Element $child
     */
    private function addElement($child)
    {
        $this->children[$child->getName()] = $child;
    }

    /**
     * Add a child to his container
     *
     * @param Element $child
     */
    function add($child)
    {
        if (method_exists($child, "setParent"))
            $child->setParent($this);

        if (method_exists($child, "getName") && $child->getName() != null) {
            $this->addElement($child);
        } else {
            $this->addChild($child);
        }
    }

    /**
     * returns the child at the specified index or
     * with the specified name.
     *
     * @param String/Integer $index
     * @return Element
     */
    function getChild($index)
    {
        return $this->children[$index];
    }

    /**
     * Returns an array of children
     *
     * @return Array
     */
    function getChildren()
    {
        return $this->children;
    }

    /**
     * Removes the child with the specified name
     * or at the specified index.
     *
     * @param unknown_type $index
     */
    function remove($index)
    {
        unset($this->children[$index]);
    }
}

/**
 * The Block class.  It is used to hold
 * a group of fields.
 *
 * @package Form
 * @subpackage Blocks
 * @abstract
 */
class Block extends Container implements Visual {

    /**
     * Enter description here...
     *
     * @param Field (or subclasses) $field
     * @param Boolean $required
     */
    function add(&$field, $required = false)
    {
        parent::add($field);
    }

    /**
     * Validates itself and its children..
     *
     * @param Array $vars
     * @return Boolean
     */
    function validate($vars)
    {
        $foundErrors = false;

        $children = $this->getChildren();
        foreach ($children as $name=>$field)
        {
            $flag = $field->validate($vars[$field->getName()]);
            if (!$flag && !$foundErrors)
            {
                $foundErrors = true;
            }
        }

        $this->setErrors($foundErrors);

        return !$foundErrors;
    }

    /**
     * Displays a Block
     *
     * @return String
     */
    function display()
    {
        $this->loadTemplates();

        $ret .= str_replace("%blockname%", $this->getName(), $this->tmpl_blockrow);

        if ($this->hasErrors())
        {
            $errors = $this->getErrors();
            $ret .= $this->tmpl_errorrow;
        }

        $ret .= $this->tmpl_blockheader;

        $children = $this->getChildren();
        foreach ($children as $name=>$field)
        {
            $ret .= $field->display();

        }
        $ret .= $this->tmpl_blockfooter;

        //$ret .= $this->tmpl_blockfooter;
        return $ret;
    }

    /**
     * Loads the templates that will be used with this block.
     *
     */
    function loadTemplates()
    {
        $this->tmpl_blockrow = '
            <tr>
                <td class=f_blockname>%blockname%</td>
            </tr>
        ';

        $this->tmpl_blockheader = "\n".'<tr><td class=f_blockheader><table border="0" cellspacing="0" cellpadding="3" width="100%" >'."\n";
        $this->tmpl_blockfooter = "\n".'</table></td></tr>'."\n";

        $this->tmpl_errorrow = '
            <tr>
                <td class=f_errorrow>Some errors have occured.  Please correct these errors and try again.</td>
            </tr>
        ';
       }
}

/**
 * A block to hold hidden fields.
 *
 * @package Form
 * @subpackage Blocks
 */
class HiddenBlock extends Block {

    /**
     * Constructor
     *
     */
    function __construct()
    {
        parent::__construct("hidden");
    }

    /**
     * Load the required templates
     *
     */
    function loadTemplates()
    {
        $this->tmpl_blockrow = '';

        $this->tmpl_blockheader = '<!-- Hidden Fields -->';
        $this->tmpl_blockfooter = "\n<!-- Hidden Fields -->\n";
        $this->tmpl_errorrow = '<!-- %errors% -->';
       }

              /**
        * Hidden fields don't need to be validated.
        *
        */
       function validate($value)
       {
           return true;
       }

}

/**
 * A block that contains control buttons
 *
 * @package Form
 * @subpackage Blocks
 */
class ControlsBlock extends Block {

    /**
     * Constructs a Control Block
     *
     */
    function __construct()
    {
        parent::__construct("controls");
    }

    /**
     * Validates itself but always returns true.
     *
     * @param Array $vars
     * @return Boolean
     */
    function validate($vars)
    {
        return true;
    }

    /**
     * Loads the templates that are used to display this block
     *
     */
    function loadTemplates()
    {
        $this->tmpl_blockrow = '';

        $this->tmpl_blockheader = "\n<tr><td class=f_controlsrow>\n";
        $this->tmpl_blockfooter = "\n</td></tr>\n";
        $this->tmpl_errorrow = '<!-- %errors% -->';
    }
}

/**
 * The Main Form object
 *
 * @package Form
 * @subpackage Form
 */
class Form extends Container implements Visual {

    /**
     * The form action
     *
     * @var String
     */
    private $action;
    /**
     * The form method
     *
     * @var String
     */
    private $method;

    /**
     * A block to hold the hidden fields
     *
     * @var HiddenBlock
     */
    public $hiddenBlock;
    /**
     * The block to hold the controls
     *
     * @var ControlsBlock
     */
    public $controlsBlock;

    /**
     * The description of this Form..
     *
     * @var String
     */
    private $description;

    /**
     * The Form constructor
     *
     * @param String $name
     * @param String $action
     * @param String $method
     */
    function __construct($name, $action, $method = "POST")
    {
        parent::__construct($name);

        $this->action = $action;
        $this->method = $method;

        $this->blocks = array();

        $this->hiddenBlock = new HiddenBlock();
        $this->controlsBlock = new ControlsBlock();

        $this->add($this->hiddenBlock);
        $this->add($this->controlsBlock);

        $this->loadTemplates();
    }

    /**
     * Sets a description for this form
     *
     * @param String $text
     */
    function setDescription($text)
    {
        $this->description = $text;
    }

    /**
     * returns the description for the form
     *
     * @return String
     */
    function getDescription()
    {
        return $this->description;
    }


    /**
     * Moves a field to the hidden block
     *
     * @param Field $field
     */
    function moveFieldToHidden($field)
    {
        $field->getParent()->remove($field->getName());

        $field2 = new Hidden($field->getName(), $field->getValue());

        $childrean = $this->getChildren();

        $this->get("hidden")->add($field2);
    }


    /**
     * Validates its blocks
     *
     * @param Array $vars
     * @return Boolean
     */
    function validate($vars)
    {

        $foundErrors = false;
        $children = $this->getChildren();
        foreach ($children as $name=>$field)
        {
            $flag = $field->validate($vars);
            if (!$flag && !$foundErrors)
            {
                $foundErrors = true;
            }
        }

        return !$foundErrors;
    }

    /**
     * Resets this form (Not Implemented)
     *
     */
    function reset()
    {

    }

    /**
     * Loads templates that are to be used by this form.
     *
     */
    function loadTemplates()
    {
        $this->tmpl_errorrow = '
            <tr>
                <td class=f_errorrow>Some errors have occured.  Please correct these errors and try again.</td>
            </tr>
        ';

        $this->tmpl_formheader = '
            <tr>
                <td class=f_formheader>%name%</td>
            </tr>
        ';

        $this->tmpl_description = '
            <tr>
                <td class=f_main_description>%text%</td>
            </tr>
        ';


        $this->tmpl_tableheader = "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" class=f_maintable>";

        $this->tmpl_tablefooter = "</table>";
    }

    /**
     * Asias of __toString();
     *
     * @return String
     */
    function display()
    {
        return $this->__toString();
    }

    /**
     * Returns the String Representation of this form
     *
     * @return String
     */
    function __toString()
    {
        $frm = '<form name="'.$this->getName().'" action="'.$this->action.'" method="'.$this->method.'">';
        $frm .= $this->tmpl_tableheader;

        $frm .= str_replace("%name%", $this->getName(), $this->tmpl_formheader);

        /*
        if ($this->hasErrors())
        {
            $frm .= $this->tmpl_errorrow;
        }
        */

        if (!empty($this->description))
        {
            $frm .= str_replace("%text%", $this->description, $this->tmpl_description);
        }

        $children = $this->getChildren();
        foreach ($children as $name=>$element)
        {
            if ($name == "hidden" || $name == "controls")
                continue;

            $frm .= $element->display();
        }

        $frm .= $this->controlsBlock->display();

        $frm .= $this->tmpl_tablefooter;

        $frm .= $this->hiddenBlock->display();

        $frm .= '</form>';

        return $frm;
    }
}

/**
 * The abstract field object.
 * Extends the Validator Container..
 *
 * @package Form
 * @subpackage Fields
 * @abstract
 */
abstract class Field extends Container implements Visual {

    /**
     * The current value of this field
     *
     * @var String
     */
    protected $value;
    /**
     * The message shown when the form is displayed
     *
     * @var Sting
     */
    protected $message;

    /**
     * The default value of this Field
     *
     * @var String
     */
    protected $default_value;

    /**
     * Is this field required?
     *
     * @var Boolean
     */
    protected $required = false;

    /**
     * A field description
     *
     * @var String
     */
    protected $description;

    /**
     * The display type of this field
     *
     * @var String
     */
    protected $display = "field";

    /**
     * The template to use when displaying errors;
     *
     * @var String
     */
    protected $errorTemplate = '<div class="f_errordiv">%field%<BR>%error%</div>';

    /**
     * Default constructor the Field Object
     *
     * @param String $name
     * @param String $message
     * @param String $value
     */
    function __construct($name, $message, $value="")
    {
        parent::__construct($name);
        $this->message = $message;
        $this->value = $value;
        $this->default_value = $value;
    }

    /**
     * Gets the message for this field
     *
     * @return String
     */
    function getMessage()
    {
        if ($this->required)
            return "<b>".stripslashes($this->message)."</b>: ";
        else
            return stripslashes($this->message).": ";
    }

    /**
     * Wraper function to add a validator to this Field
     * Checks if the validator is a RequiredFieldValidator
     * if so, it sets the required variable and then adds the
     * validator to the container.
     *
     * @param Validator $validator
     */

    /**
     * Resets this field to its original value and removes any errors
     *
     */
    function reset()
    {
        $this->value = $this->default_value;
        parent::reset();
    }

    /**
     * Validates itself using its validators..
     *
     * @param String $value
     * @return Boolean
     */
    function validate($value)
    {
        $this->value = $value;

        $hasErrors = false;

        $children = $this->getChildren();

        $this->setErrors($hasErrors);

        return !$hasErrors;
    }

    /**
     * Returns the complete displayabe version of this field
     *
     * @return String
     */
    function getCompleteField()
    {
        if ($this->display != "field")
            $field = $this->getLabel();
        else
            $field = $this->getField();

        if ($this->hasErrors())
        {
            $ffield = str_replace("%field%", $field, $this->errorTemplate);
            $ffield = str_replace("%error%", $this->getErrors(), $ffield);
            return $ffield;
        }

        return $field;
    }

    /**
     * returns a Label representation of this field
     *
     * @return String
     */
    function getLabel()
    {
        switch ($this->display)
        {
            case "integer":
                $value = intval($this->value);
                break;

            case "currency":
                $value = number_format($this->value, 2, ".", "");
                break;

            default:
                $value = $this->value;
        }
        return "<font class=f_label>".stripslashes($value)."</font><input type=\"hidden\" name=\"".$this->getName()."\" value=\"".stripslashes($value)."\">";
    }

    /**
     * returns the HTML input field
     *
     * @abstract
     */
    abstract function getField();

    /**
     * Returns a String representation of this object
     *
     * @return String
     */
    function __toString()
    {
        return $this->getCompleteField();
    }

    /**
     * Sets the Description
     *
     * @param String $desc
     */
    function setDescription($desc)
    {
        $this->description = $desc;
    }

    /**
     * gets the description
     *
     * @return String
     */
    function getDescription()
    {
        return stripslashes($this->description);
    }

    /**
     * Gets the current value
     *
     * @return String
     */
    function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the current value.
     *
     * @param String $value
     */
    function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Sets how this field should be displayed
     *
     * @param String $display
     */
    function setDisplay($display)
    {
        $this->display = $display;
    }

    /**
     * Displays the Field
     *
     * @return String
     */
    function display()
    {
        $this->loadTemplates();
        $matches = array();
        $replace = array();

        $matches[] = "#%text%#is";
        $matches[] = "#%field%#is";
        $matches[] = "#%description%#is";

        $replace[] = $this->getMessage();
        $replace[] = $this->getCompleteField();
        $replace[] = $this->getDescription();

        return preg_replace($matches, $replace, $this->tmpl_genericrow);
    }

    /**
     * Loads the templates that will be used in displaying this field.
     *
     */
    function loadTemplates()
    {
        $this->tmpl_genericrow = '
                <tr class=f_genericrow>
                    <td class=f_left_column>%text%</td>
                    <td class=f_right_column>
                        <table border=0 width=100%><tr>
                            <td>%field%</td>
                            <td><span class=f_description>&nbsp;%description%</span></td>
                        </table>
                    </td>
                </tr>
        ';
    }

}

/**
 * A label that displays its value.
 *
 * @package Form
 * @subpackage Fields
 */
class Label extends Field {

    /**
     * returns the string representation of this field
     *
     * @return String
     */
    function getField()
    {
        return "<font class=f_label>".$this->value."</font>";
    }

    /**
     * validates itself... but always returns true..
     *
     * @return Boolean
     */
    function validate($value)
    {
        return true;
    }
}

/**
 * A text field
 *
 * @package Form
 * @subpackage Fields
 */
class Text extends Field {

    function getField()
    {
        $txt = '<input type="text" name="'.$this->getName().'" value="'.stripslashes($this->value).'">';
        return $txt;
    }
}

/**
 * A hidden field
 *
 * @package Form
 * @subpackage Fields
 */
class Hidden extends Field {

    /**
     * Constructs itself
     *
     * @param String $name
     * @param String $value
     */
    function __construct($name, $value)
    {
        parent::__construct($name, "", $value);
    }

    /**
     * returns the string representation of this field
     *
     * @return String
     */
    function getField()
    {
        $txt = '<input type="hidden" name="'.$this->getName().'" value="'.stripslashes($this->value).'">';
        return $txt;
    }

    /**
     * Loads the templates that are to be used by this field.
     *
     */
    function loadTemplates()
    {
        $this->tmpl_genericrow = '
                %field%
        ';
    }
}

/**
 * A password field..
 *
 * @package Form
 * @subpackage Fields
 */
class Password extends Field {
    function getField()
    {
        $txt = '<input type="password" name="'.$this->getName().'">';
        return $txt;
    }
}

/**
 * A textarea.
 *
 * @package Form
 * @subpackage Fields
 */
class TextArea extends Field {

    /**
     * The number of rows
     *
     * @var Integer
     */
    private $rows;
    /**
     * The number of columns
     *
     * @var Integer
     */
    private $cols;

    /**
     * The constructor
     *
     * @param String $name
     * @param String $message
     * @param String $value
     * @param Integer $rows
     * @param Integer $cols
     */
    function __construct($name, $message, $value = "", $rows = 5, $cols = 30)
    {
        parent::__construct($name, $message, $value);
        $this->rows = $rows;
        $this->cols = $cols;
    }

    function getField()
    {
        $txt = '<textarea name="'.$this->getName().'" rows="'.$this->rows.'" cols="'.$this->cols.'">'.stripslashes($this->value).'</textarea>';
        return $txt;
    }
}

/**
 * A checkbox Field.
 *
 * @package Form
 * @subpackage Fields
 */
class Checkbox extends Field {

    /**
     * The message that is displayed by the checkbox..
     *
     * @var String
     */
    private $Fmessage;
    /**
     * the value that goes into the "value" field of the checkbox
     *
     * @var String
     */
    private $realValue;

    /**
     * Construct the Checkbox
     *
     * @param String $name
     * @param String $message
     * @param String $value
     * @param String $realValue
     * @param String $Fmessage
     */
    function __construct($name, $message, $value = "", $realValue, $Fmessage)
    {
        parent::__construct($name, $message, $value);
        $this->Fmessage = $Fmessage;
        $this->realValue = $realValue;
    }

    /**
     * returns the string representation of this field
     *
     * @return String
     */
    function getField()
    {
        if ($this->value != "")
            $checked = "checked";
        else
            $checked = "";
        $txt = '<input type="checkbox" name="'.$this->getName().'" value="'.stripslashes($this->realValue).'" '.$checked.'> <font class=f_label>'.stripslashes($this->Fmessage).'</font>';
        return $txt;
    }
}

/**
 * A select Field
 *
 * @package Form
 * @subpackage Fields
 */
class Select extends Field {

    /**
     * An array of option for the select box
     *
     * @var Array
     */
    private $options;
    /**
     * Size of field. Use for multiple selects
     *
     * @var Integer
     */
    private $size;

    /**
     * Message shows on the default option of the select box.
     *
     * @var String
     */
    private $Fmessage;

    /**
     * The constructor
     *
     * @param String $name
     * @param String $message
     * @param String $value
     * @param String $Fmessage
     * @param String $options
     * @param String $size
     */
    function __construct($name, $message, $value="", $Fmessage, &$options, $size=1)
    {
        parent::__construct($name, $message, $value);

        $this->Fmessage = $Fmessage;
        $this->options = $options;
        $this->size=$size;
    }

    /**
     * Sets the options of the field
     *
     * @param Array $options
     */
    function setOptions(&$options)
    {
        $this->options = $options;
    }

    function getField()
    {
        if ($this->size > 1)
            $size = 'size="'.$this->size.'"';

        $txt = '<select name="'.$this->getName().'" '.$size.'>';
        $txt .= '<option value="-1">'.stripslashes($this->Fmessage).'</option>';
        $mainArr = new ArrayObject($this->options);
        for ($mainIterator = $mainArr->getIterator(); $mainIterator->valid(); $mainIterator->next())
        {
            if ($this->value == $mainIterator->key())
                $selected = " selected";
            else
                $selected = "";

            $txt .= '<option value="'.$mainIterator->key().'"'.$selected.'>'.stripslashes($mainIterator->current()).'</option>';
        }
        $txt .= '</select>';

        return $txt;
    }

    /**
     * Override the parent method to add
     * special handling of the value
     *
     * @param String $value
     * @return Boolean
     */
    function validate($value)
    {
        if ($value == "-1")
            $value = "";
        return parent::validate($value);
    }
}

/**
 * A button object
 *
 * @package Form
 * @subpackage Fields
 */
class Button extends Field {

    /**
     * The type of the button..
     * Can be button, submit, rest
     *
     * @var String
     */
    private $type;

    /**
     * Construct the Button
     *
     * @param String $value
     * @param String $type
     */
    function __construct($value, $type = "submit")
    {
        parent::__construct($value, "", $value);
        $this->type = $type;
    }


    /**
     * Render the Field
     *
     * @return String
     */
    function getField()
    {
        $txt = '<input type="'.$this->type.'" name="'.$this->type.'" value="'.stripslashes($this->value).'">';
        return $txt;
    }

    /**
     * Load the Templates
     *
     */
    function loadTemplates()
    {
        $this->tmpl_genericrow = '
                %field%
        ';
    }

}

/**
 * A Text Row object
 *
 * @package Form
 * @subpackage Fields
 */
class TextRow extends Field {

    /**
     * The type of the button..
     * Can be button, submit, rest
     *
     * @var String
     */
    private $type;

    /**
     * Construct the Button
     *
     * @param String $value
     * @param String $type
     */
    function __construct($name, $value)
    {
        parent::__construct($name, "", $value);
        $this->type = "Textrow";
    }


    /**
     * Render the Field
     *
     * @return String
     */
    function getField()
    {
        $txt = $this->value;
        return $txt;
    }

    /**
     * Load the Templates
     *
     */
    function loadTemplates()
    {
        $this->tmpl_genericrow = '
                <tr class=f_genericrow><td colspan=2 class=f_textrow>%field%</td></tr>
        ';
    }

}

?>
