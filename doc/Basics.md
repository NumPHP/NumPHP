# Basics

## Create NumArray

* integer
    ```
    $numArray = new NumArray(1);
    echo $numArray;
    ```
    Output:
    ```
    1
    ```

* vector
    ```
    $numArray = new NumArray([1, 2]);
    echo $numArray;
    ```
    Output:
    ```
    (
      1,
      2
    )
    ```

* matrix
    ```
    $numArray = new NumArray(
        [
            [1, 2],
            [3, 4]
        ]
    );
    echo $numArray;
    ```
    Output:
    ```
    (
      (
        1,
        2
      ),
      (
        3,
        4,
      )
    )
    ```
