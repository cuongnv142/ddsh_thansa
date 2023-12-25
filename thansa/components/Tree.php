<?php

namespace app\components;

class Tree {

    protected $tree;
    protected $rootid;
    protected $arr;

    public function __construct($entries) {
        $this->tree = array();
        $this->rootid = PHP_INT_MAX;

        /* Build tree under each node */
        foreach ($entries as $node)
            $this->buildTree($this->tree, $node);
    }

    /* Build tree */

    protected function buildTree(&$tree, $node) {
        $i = $node['id'];
        $p = $node['pid'];
        $this->rootid = min($this->rootid, $p);
        $tree[$i] = isset($tree[$i]) ? $node + $tree[$i] : $node;
        $tree[$p]['_children'][] = &$tree[$i];
    }

    /* Print tree */

    public function printTree() {
        $this->printSubtree($this->tree[$this->rootid]);
    }

    /* Print subtree under given node */

    protected function printSubtree($node, $depth = 0) {
        /* Root node doesn't have id */
        if (isset($node['id'])) {
            echo str_repeat('-', $depth - 1) . $node['name'], "<br>\n";
            $this->arr[$node['id']] = str_repeat('-', $depth - 1) . $node['name'];
        }

        /* Explore children */
        if (isset($node['_children'])) {
            foreach ($node['_children'] as $child)
                $this->printSubtree($child, $depth + 1);
        }
    }

    /* Print tree */

    public function getArrayForDropdownList() {
        if ($this->rootid == PHP_INT_MAX) return [];
        $this->arr = [];
        $this->printSubtree2($this->tree[$this->rootid]);
        return $this->arr;
    }

    /* Print subtree under given node */

    protected function printSubtree2($node, $depth = 0) {
        /* Root node doesn't have id */
        if (isset($node['id'])) {
            $this->arr[$node['id']] = str_repeat('-', $depth - 1) . $node['name'];
        }

        /* Explore children */
        if (isset($node['_children'])) {
            foreach ($node['_children'] as $child)
                $this->printSubtree2($child, $depth + 1);
        }
    }

    /* Destroy instance data */

    public function __destruct() {
        $this->tree = null;
    }

}

/*
 $entries = array(
  array('pid' => 2, 'id' => 3, 'name' => 'Ba'),
  array('pid' => 0, 'id' => 2, 'name' => 'Hai'),
  array('pid' => 3, 'id' => 7, 'name' => 'Bay'),
  array('pid' => 2, 'id' => 4, 'name' => 'Bon'),
  array('pid' => 2, 'id' => 6, 'name' => 'Sau'),
  array('pid' => 3, 'id' => 8, 'name' => 'Tam'),
  array('pid' => 0, 'id' => 9, 'name' => 'Chin'),
);

$tree = new Tree($entries);
$tree->printTree();
 */