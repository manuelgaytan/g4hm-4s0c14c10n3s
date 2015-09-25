<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Propel\Generator\Behavior\ConcreteInheritance;

use Propel\Generator\Exception\InvalidArgumentException;
use Propel\Generator\Model\Behavior;
use Propel\Generator\Model\ForeignKey;

/**
 * Makes a model inherit another one. The model with this behavior gets a copy
 * of the structure of the parent model. In addition, both the ActiveRecord and
 * ActiveQuery classes will extend the related classes of the parent model.
 * Lastly (an optionally), the data from a model with this behavior is copied
 * to the parent model.
 *
 * @author François Zaninotto
 */
class ConcreteInheritanceBehavior extends Behavior
{
    // default parameters value
    protected $parameters = array(
        'extends'             => '',
        'descendant_column'   => 'descendant_class',
        'copy_data_to_parent' => 'true',
        'copy_data_to_child'  => 'false',
        'schema'              => ''
    );

    public function modifyTable()
    {
        $table = $this->getTable();
        $parentTable = $this->getParentTable();

        if ($this->isCopyData()) {
            // tell the parent table that it has a descendant
            if (!$parentTable->hasBehavior('concrete_inheritance_parent')) {
                $parentBehavior = new ConcreteInheritanceParentBehavior();
                $parentBehavior->setName('concrete_inheritance_parent');
                $parentBehavior->addParameter(array('name' => 'descendant_column', 'value' => $this->getParameter('descendant_column')));
                $parentTable->addBehavior($parentBehavior);
                // The parent table's behavior modifyTable() must be executed before this one
                $parentBehavior->getTableModifier()->modifyTable();
                $parentBehavior->setTableModified(true);
            }
        }

        // Add the columns of the parent table
        foreach ($parentTable->getColumns() as $column) {
            if ($column->getName() == $this->getParameter('descendant_column')) {
                continue;
            }
            if ($table->hasColumn($column->getName())) {
                continue;
            }
            $copiedColumn = clone $column;
            if ($column->isAutoIncrement() && $this->isCopyData()) {
                $copiedColumn->setAutoIncrement(false);
            }
            $table->addColumn($copiedColumn);
            if ($column->isPrimaryKey() && $this->isCopyData()) {
                $fk = new ForeignKey();
                $fk->setForeignTableCommonName($column->getTable()->getCommonName());
                if ($table->guessSchemaName() != $column->getTable()->guessSchemaName()) {
                    $fk->setForeignSchemaName($column->getTable()->guessSchemaName());
                }
                $fk->setOnDelete('CASCADE');
                $fk->setOnUpdate(null);
                $fk->addReference($copiedColumn, $column);
                $fk->isParentChild = true;
                $table->addForeignKey($fk);
            }
        }

        // add the foreign keys of the parent table
        foreach ($parentTable->getForeignKeys() as $fk) {
            $copiedFk = clone $fk;
            $copiedFk->setName('');
            $copiedFk->setRefPhpName('');
            $this->getTable()->addForeignKey($copiedFk);
        }

        // add the indices of the parent table
        foreach ($parentTable->getIndices() as $index) {
            $copiedIndex = clone $index;
            $copiedIndex->setName('');
            $this->getTable()->addIndex($copiedIndex);
        }

        // add the unique indices of the parent table
        foreach ($parentTable->getUnices() as $unique) {
            $copiedUnique = clone $unique;
            $copiedUnique->setName('');
            $this->getTable()->addUnique($copiedUnique);
        }

        // add the Behaviors of the parent table
        foreach ($parentTable->getBehaviors() as $behavior) {
            if ($behavior->getName() == 'concrete_inheritance_parent' || $behavior->getName() == 'concrete_inheritance') {
                continue;
            }
            // validate behavior. If validate behavior already exists, clone only rules from parent
            if ('validate' === $behavior->getName() && $table->hasBehavior('validate')) {
                $table->getBehavior('validate')->mergeParameters($behavior->getParameters());

                continue;
            }
            $copiedBehavior = clone $behavior;
            $copiedBehavior->setTableModified(false);
            $this->getTable()->addBehavior($copiedBehavior);
        }

    }

    protected function getParentTable()
    {
        $database = $this->getTable()->getDatabase();
        $tableName = $database->getTablePrefix() . $this->getParameter('extends');
        if ($database->getPlatform()->supportsSchemas() && $this->getParameter('schema')) {
            $tableName = $this->getParameter('schema').$database->getPlatform()->getSchemaDelimiter().$tableName;
        }

        if (!$table = $database->getTable($tableName)) {
            throw new InvalidArgumentException(sprintf('Table "%s" used in the concrete_inheritance behavior at table "%s" not exist.', $tableName, $this->getTable()->getName()));
        }

        return $table;
    }

    protected function isCopyData()
    {
        return 'true' === $this->getParameter('copy_data_to_parent');
    }

    /**
     * @return string[]|bool
     */
    protected function getCopyToChild()
    {
        if ('false' === strtolower($this->getParameter('copy_data_to_child'))) {
            return false;
        }

        if ('true' === strtolower($this->getParameter('copy_data_to_child'))) {
            return true;
        }

        return explode(',', str_replace(' ', '', $this->getParameter('copy_data_to_child')));
    }

    public function parentClass($builder)
    {
        $parentTable = $this->getParentTable();
        switch (get_class($builder)) {
            case 'Propel\Generator\Builder\Om\ObjectBuilder':
                return $builder->declareClassFromBuilder($builder->getNewStubObjectBuilder($parentTable), true);
            case 'Propel\Generator\Builder\Om\QueryBuilder':
                return $builder->declareClassFromBuilder($builder->getNewStubQueryBuilder($parentTable), true);
        }

        return null;
    }

    public function preSave()
    {
        if ($this->isCopyData()) {
            $script = "\$parent = \$this->getSyncParent(\$con);
\$parent->save(\$con);
\$this->setPrimaryKey(\$parent->getPrimaryKey());
";

            if ($this->getCopyToChild()) {
                $script .= "\$this->syncParentToChild(\$parent);\n";
            }

            return $script;
        }
    }

    public function postDelete($script)
    {
        if ($this->isCopyData()) {
            return "\$this->getParentOrCreate(\$con)->delete(\$con);
";
        }
    }

    public function objectMethods($builder)
    {
        $script = '';
        $this->builder = $builder;

        if ($this->isCopyData()) {
            $this->addObjectGetParentOrCreate($script);
            $this->addObjectGetSyncParent($script);
        }

        if ($this->getCopyToChild()) {
            $this->addSyncParentToChild($script);
        }

        return $script;
    }

    protected function addSyncParentToChild(&$script)
    {
        $parentTable = $this->getParentTable();
        $parentClass = $this->builder->getClassNameFromBuilder($this->builder->getNewStubObjectBuilder($parentTable));

        $script .= "
/**
 * This method syncs additional columns from parent to child, defined by
 * ConcreteBehavior's `copy_data_to_child` parameter.
 *
 * This method is called in preSave of child, but postSave of parent, so you
 * have basically access to generated IDs (or generated columns by triggers if you have
 * `reloadoninsert` at the parent table activated).
 *
 * @param $parentClass \$parent The parent object
 */
public function syncParentToChild($parentClass \$parent)
{
    ";

        $columns = $this->getCopyToChild();
        if (true === $columns) {
            $columns = $parentTable->getColumns();
        } else {
            $columnNames = $columns;
            $columns = [];
            foreach ($columnNames as $columnName) {
                $column = $this->getTable()->getColumn($columnName);
                $columns[] = $column;
            }
        }

        foreach ($columns as $column) {
            if ($column->isPrimaryKey()) {
                // exclude primary keys, because they are already synced to child
                continue;
            }

            $getter = 'get' . ucfirst($column->getPhpName());
            $setter = 'set' . ucfirst($column->getPhpName());


            $script .= "
    \$this->{$setter}(\$parent->{$getter}());
            ";
        }

        $script .= "
}
";
    }

    protected function addObjectGetParentOrCreate(&$script)
    {
        $parentTable = $this->getParentTable();
        $parentClass = $this->builder->getClassNameFromBuilder($this->builder->getNewStubObjectBuilder($parentTable));
        $script .= "
/**
 * Get or Create the parent " . $parentClass . " object of the current object
 *
 * @return    " . $parentClass . " The parent object
 */
public function getParentOrCreate(\$con = null)
{
    if (\$this->isNew()) {
        if (\$this->isPrimaryKeyNull()) {
            \$parent = new " . $parentClass . "();
            \$parent->set" . $this->getParentTable()->getColumn($this->getParameter('descendant_column'))->getPhpName() . "('" . $this->builder->getStubObjectBuilder()->getQualifiedClassName() . "');

            return \$parent;
        } else {
            \$parent = " . $this->builder->getNewStubQueryBuilder($parentTable)->getClassname() . "::create()->findPk(\$this->getPrimaryKey(), \$con);
            if (null === \$parent || null !== \$parent->getDescendantClass()) {
                \$parent = new " . $parentClass . "();
                \$parent->setPrimaryKey(\$this->getPrimaryKey());
                \$parent->set" . $this->getParentTable()->getColumn($this->getParameter('descendant_column'))->getPhpName() . "('" . $this->builder->getStubObjectBuilder()->getQualifiedClassName() . "');
            }

            return \$parent;
        }
    } else {
        return " . $this->builder->getClassNameFromBuilder($this->builder->getNewStubQueryBuilder($parentTable)) . "::create()->findPk(\$this->getPrimaryKey(), \$con);
    }
}
";
    }

    protected function addObjectGetSyncParent(&$script)
    {
        $parentTable = $this->getParentTable();
        $pkeys = $parentTable->getPrimaryKey();
        $cptype = $pkeys[0]->getPhpType();
        $script .= "
/**
 * Create or Update the parent " . $parentTable->getPhpName() . " object
 * And return its primary key
 *
 * @return    " . $cptype . " The primary key of the parent object
 */
public function getSyncParent(\$con = null)
{
    \$parent = \$this->getParentOrCreate(\$con);";
        foreach ($parentTable->getColumns() as $column) {
            if ($column->isPrimaryKey() || $column->getName() == $this->getParameter('descendant_column')) {
                continue;
            }
            $phpName = $column->getPhpName();
            $script .= "
    \$parent->set{$phpName}(\$this->get{$phpName}());";
        }
        foreach ($parentTable->getForeignKeys() as $fk) {
            if (isset($fk->isParentChild) && $fk->isParentChild) {
                continue;
            }
            $refPhpName = $this->builder->getFKPhpNameAffix($fk, false);
            $script .= "
    if (\$this->get" . $refPhpName . "() && \$this->get" . $refPhpName . "()->isNew()) {
        \$parent->set" . $refPhpName . "(\$this->get" . $refPhpName . "());
    }";
        }
        $script .= "

    return \$parent;
}
";
    }
}