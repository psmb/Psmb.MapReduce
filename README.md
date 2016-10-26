# Psmb.MapReduce

This package provides `.map()` and `.reduce()` FlowQuery operations.
Could be useful, huh?

## Installation

`composer require 'psmb/mapreduce:@dev'`

## Usage

### Map

Takes all items in current FlowQuery context, and transforms each value with given Eel operation.
There is a context variable `value` available, with a value of a current node.

E.g. this would give you an array of identifiers of all child nodes of a given node:
```
${q(node).children().map('value.identifier')}
```

See: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/map

### Reduce

Takes an Eel Expression as a first argument and initial values as the second. Injects `previousValue`,
`currentValue`, `index` and `array` context variables.

E.g. imagine you have a collection of Order nodes, where each node has a price property.
Now let's try to get a total price for all of the give nodes:

```
${q(node).children('orders').reduce('previousValue + currentValue.properties.price', 0)
```

See: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/Reduce
