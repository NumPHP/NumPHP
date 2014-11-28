# Basics

## NumArray

A `NumArray` is the main object of NumPHP. It can represent a 1-dim, 2-dim, 3-dim, ... array.
A 1-dim array can be a vector, a 2-dim a matrix. A NumArray needs just an normal PHP array as input.
Here is one little example.

    use NumPHP\Core\NumArray;
    
    $numArray = new NumArray(
        [
            [14.28, -867.1, 45.6],
            [4.32, 8031, -564.1]
        ]
    );
    echo $numArray;
Output:

    (
        (
            14.28,
            -867.1,
            45.6
        ),
        (
            4.32,
            8031,
            -564.1
        )
    )
    
### Shape

The function `getShape` will return the shape of an NumArray

    print_r($numArray->getShape());
Output:

    Array
    (
        [0] => 2
        [1] => 3
    )

### Size

The function `getSize` will return the count of all elements in the NumArray

    echo $numArray->getSize();
Output:

    6

### NDim

The function `getNDim` will return the dimensions of the NumArray

    echo $numArray->getNDim();
Output:

    2

### Data

The function `getData` will return the stored data of the NumArray. In the most cases, this should be an normal array.

    print_r($numArray->getData());
Output:

    Array
    (
        [0] => Array
            (
                [0] => 14.28
                [1] => 867.1
                [2] => 45.6
            )
        
        [1] => Array
            (
                [0] => 4.32
                [1] => 8031
                [2] => -564.1
            )
            
    )
