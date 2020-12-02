## Endpoints

| Name                            | Method | URI               |
| :---                            | :---   | :---              |
| [Solve Maze](#POST-solve-maze)  | `POST` | api/v1/maze/solve |

## <a name="GET-solve-maze"></a>Solve Maze
Solve Maze

### Request

#### Example

```http
POST api/v1/maze/solve
{
    "type": "characters",
    "sequence": "CCC-DDD-EEE-DDD",
    "entrance": "B",
    "exit": "B",
    "maze": [
        ["A", "B", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"],
        ["A", "C", "A", "D", "D", "E", "A", "C", "C", "C", "D", "A"],
        ["A", "C", "C", "D", "A", "E", "A", "D", "A", "D", "A", "A"],
        ["A", "A", "A", "A", "A", "E", "D", "D", "A", "D", "E", "A"],
        ["A", "C", "C", "D", "D", "D", "A", "A", "A", "A", "E", "A"],
        ["A", "C", "A", "A", "A", "A", "A", "D", "D", "D", "E", "A"],
        ["A", "D", "D", "D", "E", "E", "A", "C", "A", "A", "A", "A"],
        ["A", "A", "A", "E", "A", "E", "A", "C", "C", "D", "D", "A"],
        ["A", "D", "E", "E", "A", "D", "A", "A", "A", "A", "A", "A"],
        ["A", "A", "D", "A", "A", "D", "A", "C", "D", "D", "A", "A"],
        ["A", "D", "D", "D", "A", "D", "C", "C", "A", "D", "E", "B"],
        ["A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"]
    ]
}
```

### Response

#### Success response

```http
HTTP/1.1 200 Ok
Content-type: application/json
```

```json
{
    "metadata": {
        "code": 200,
        "message": "OK"
    },
    "data": {
        "paths_count": 127,
        "successful_solutions": {
            "paths_count": 16,
            "successful_paths": [
                {
                    "status": "success",
                    "matrix": [
                        "-|B|-|-|-|-|-|-|-|-|-|-",
                        "-|C|-|D|D|E|-|-|-|-|-|-",
                        "-|C|C|D|-|E|-|-|-|-|-|-",
                        "-|-|-|-|-|E|-|-|-|-|-|-",
                        "-|C|C|D|D|D|-|-|-|-|-|-",
                        "-|C|-|-|-|-|-|-|-|-|-|-",
                        "-|D|D|D|E|E|-|-|-|-|-|-",
                        "-|-|-|-|-|E|-|-|-|-|-|-",
                        "-|-|-|-|-|D|-|-|-|-|-|-",
                        "-|-|-|-|-|D|-|C|D|D|-|-",
                        "-|-|-|-|-|D|C|C|-|D|E|B",
                        "-|-|-|-|-|-|-|-|-|-|-|-"
                    ],
                    "path": [
                        {
                            "row": 0,
                            "column": 1,
                            "value": "B"
                        },
                        {
                            "row": 1,
                            "column": 1,
                            "value": "C"
                        },
                        {
                            "row": 2,
                            "column": 1,
                            "value": "C"
                        },
                        {
                            "row": 2,
                            "column": 2,
                            "value": "C"
                        },
                        {
                            "row": 2,
                            "column": 3,
                            "value": "D"
                        },
                        {
                            "row": 1,
                            "column": 3,
                            "value": "D"
                        },
                        {
                            "row": 1,
                            "column": 4,
                            "value": "D"
                        },
                        {
                            "row": 1,
                            "column": 5,
                            "value": "E"
                        },
                        {
                            "row": 2,
                            "column": 5,
                            "value": "E"
                        },
                        {
                            "row": 3,
                            "column": 5,
                            "value": "E"
                        },
                        {
                            "row": 4,
                            "column": 5,
                            "value": "D"
                        },
                        {
                            "row": 4,
                            "column": 4,
                            "value": "D"
                        },
                        {
                            "row": 4,
                            "column": 3,
                            "value": "D"
                        },
                        {
                            "row": 4,
                            "column": 2,
                            "value": "C"
                        },
                        {
                            "row": 4,
                            "column": 1,
                            "value": "C"
                        },
                        {
                            "row": 5,
                            "column": 1,
                            "value": "C"
                        },
                        {
                            "row": 6,
                            "column": 1,
                            "value": "D"
                        },
                        {
                            "row": 6,
                            "column": 2,
                            "value": "D"
                        },
                        {
                            "row": 6,
                            "column": 3,
                            "value": "D"
                        },
                        {
                            "row": 6,
                            "column": 4,
                            "value": "E"
                        },
                        {
                            "row": 6,
                            "column": 5,
                            "value": "E"
                        },
                        {
                            "row": 7,
                            "column": 5,
                            "value": "E"
                        },
                        {
                            "row": 8,
                            "column": 5,
                            "value": "D"
                        },
                        {
                            "row": 9,
                            "column": 5,
                            "value": "D"
                        },
                        {
                            "row": 10,
                            "column": 5,
                            "value": "D"
                        },
                        {
                            "row": 10,
                            "column": 6,
                            "value": "C"
                        },
                        {
                            "row": 9,
                            "column": 7,
                            "value": "C"
                        },
                        {
                            "row": 10,
                            "column": 7,
                            "value": "C"
                        },
                        {
                            "row": 9,
                            "column": 8,
                            "value": "D"
                        },
                        {
                            "row": 9,
                            "column": 9,
                            "value": "D"
                        },
                        {
                            "row": 10,
                            "column": 9,
                            "value": "D"
                        },
                        {
                            "row": 10,
                            "column": 10,
                            "value": "E"
                        },
                        {
                            "row": 10,
                            "column": 11,
                            "value": "B"
                        }
                    ]
                },
                {
                    "status": "success",
                    "matrix": [
                        "-|B|-|-|-|-|-|-|-|-|-|-",
                        "-|C|-|D|D|E|-|-|-|-|-|-",
                        "-|C|C|D|-|E|-|-|-|-|-|-",
                        "-|-|-|-|-|E|-|-|-|-|-|-",
                        "-|C|C|D|D|D|-|-|-|-|-|-",
                        "-|C|-|-|-|-|-|-|-|-|-|-",
                        "-|D|D|D|E|E|-|-|-|-|-|-",
                        "-|-|-|-|-|E|-|-|-|-|-|-",
                        "-|-|-|-|-|D|-|-|-|-|-|-",
                        "-|-|-|-|-|D|-|C|D|D|-|-",
                        "-|-|-|-|-|D|C|C|-|D|E|B",
                        "-|-|-|-|-|-|-|-|-|-|-|-"
                    ],
                    "path": [
                        {
                            "row": 0,
                            "column": 1,
                            "value": "B"
                        },
                        {
                            "row": 1,
                            "column": 1,
                            "value": "C"
                        },
                        {
                            "row": 2,
                            "column": 1,
                            "value": "C"
                        },
                        {
                            "row": 2,
                            "column": 2,
                            "value": "C"
                        },
                        {
                            "row": 1,
                            "column": 3,
                            "value": "D"
                        },
                        {
                            "row": 2,
                            "column": 3,
                            "value": "D"
                        },
                        {
                            "row": 1,
                            "column": 4,
                            "value": "D"
                        },
                        {
                            "row": 1,
                            "column": 5,
                            "value": "E"
                        },
                        {
                            "row": 2,
                            "column": 5,
                            "value": "E"
                        },
                        {
                            "row": 3,
                            "column": 5,
                            "value": "E"
                        },
                        {
                            "row": 4,
                            "column": 5,
                            "value": "D"
                        },
                        {
                            "row": 4,
                            "column": 4,
                            "value": "D"
                        },
                        {
                            "row": 4,
                            "column": 3,
                            "value": "D"
                        },
                        {
                            "row": 4,
                            "column": 2,
                            "value": "C"
                        },
                        {
                            "row": 4,
                            "column": 1,
                            "value": "C"
                        },
                        {
                            "row": 5,
                            "column": 1,
                            "value": "C"
                        },
                        {
                            "row": 6,
                            "column": 1,
                            "value": "D"
                        },
                        {
                            "row": 6,
                            "column": 2,
                            "value": "D"
                        },
                        {
                            "row": 6,
                            "column": 3,
                            "value": "D"
                        },
                        {
                            "row": 6,
                            "column": 4,
                            "value": "E"
                        },
                        {
                            "row": 6,
                            "column": 5,
                            "value": "E"
                        },
                        {
                            "row": 7,
                            "column": 5,
                            "value": "E"
                        },
                        {
                            "row": 8,
                            "column": 5,
                            "value": "D"
                        },
                        {
                            "row": 9,
                            "column": 5,
                            "value": "D"
                        },
                        {
                            "row": 10,
                            "column": 5,
                            "value": "D"
                        },
                        {
                            "row": 10,
                            "column": 6,
                            "value": "C"
                        },
                        {
                            "row": 9,
                            "column": 7,
                            "value": "C"
                        },
                        {
                            "row": 10,
                            "column": 7,
                            "value": "C"
                        },
                        {
                            "row": 9,
                            "column": 8,
                            "value": "D"
                        },
                        {
                            "row": 9,
                            "column": 9,
                            "value": "D"
                        },
                        {
                            "row": 10,
                            "column": 9,
                            "value": "D"
                        },
                        {
                            "row": 10,
                            "column": 10,
                            "value": "E"
                        },
                        {
                            "row": 10,
                            "column": 11,
                            "value": "B"
                        }
                    ]
                },
                ...
            ]
        },
        "failed_solutions": {
            "paths_count": 111,
            "failed_paths": [
                {
                    "status": "failed",
                    "matrix": [
                        "-|B|-|-|-|-|-|-|-|-|-|-",
                        "-|C|-|D|D|-|-|-|-|-|-|-",
                        "-|C|C|D|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-"
                    ],
                    "path": [
                        {
                            "row": 0,
                            "column": 1,
                            "value": "B"
                        },
                        {
                            "row": 1,
                            "column": 1,
                            "value": "C"
                        },
                        {
                            "row": 2,
                            "column": 1,
                            "value": "C"
                        },
                        {
                            "row": 2,
                            "column": 2,
                            "value": "C"
                        },
                        {
                            "row": 1,
                            "column": 3,
                            "value": "D"
                        },
                        {
                            "row": 1,
                            "column": 4,
                            "value": "D"
                        },
                        {
                            "row": 2,
                            "column": 3,
                            "value": "D"
                        }
                    ]
                },
                {
                    "status": "failed",
                    "matrix": [
                        "-|B|-|-|-|-|-|-|-|-|-|-",
                        "-|C|-|-|-|-|-|-|-|-|-|-",
                        "-|C|C|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-",
                        "-|-|-|-|-|-|-|-|-|-|-|-"
                    ],
                    "path": [
                        {
                            "row": 0,
                            "column": 1,
                            "value": "B"
                        },
                        {
                            "row": 1,
                            "column": 1,
                            "value": "C"
                        },
                        {
                            "row": 2,
                            "column": 2,
                            "value": "C"
                        },
                        {
                            "row": 2,
                            "column": 1,
                            "value": "C"
                        }
                    ]
                },
                ...
            ]
        }
    }
}
```

### Failed Response

#### Bad request (400)
- I send and empty `type`

```http
HTTP/1.1 400 Bad Request
Content-type: application/json
```

```json
{
    "metadata": {
        "code": 400,
        "message": "Bad Request"
    },
    "data": {
        "message": "invalid body request, please check the docs"
    }
}
```