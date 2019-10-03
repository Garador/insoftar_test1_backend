<pre>
GET     /api/user?skip=_$int_&limit=_$int_      //RETURNS THE CURRENT USER DB RECORDS
POST    /api/user                           //GENERATES NEW RECORD
    REQUEST:
        TYPE: x-www-form-urlencoded
        DATA:
            REQUIRED: "email": VALID EMAIL ADDRESS,
            REQUIRED: "first_name": VALID STRING (/^[a-z ]{1,60}$/i) Letters and spaces, 1 to 60
            REQUIRED: "last_name": VALID STRING (/^[a-z ]{1,60}$/i) Letters and spaces, 1 to 60
            REQUIRED: "phone": [\d]{8,15} // only numbers (8 to 15 digits length)
            REQUIRED: "ci": [\d]{6,10} // only numbers (6 to 10 digits length)
    RESPONSE
        TYPE: JSON
        POSSIBLE RESPONSES:
            SUCCESS:
                RECORD HAS BEEN CREATED:
                    CODE: 200
                    DATA:
                        {
                            "success": true,
                            "data": {
                                "email": String,
                                "first_name": String,
                                "last_name": String,
                                "phone": String,
                                "ci": String,
                                "updated_at": String,
                                "created_at": String,
                                "id": number
                            },
                            "message": "User created successfully."
                        }
            ERROR:
                REQUEST HAS INVALID DATA:
                    CODE: 400
                    DATA:
                        {
                            "success": false,
                            "message": "Validation Error.",
                            "data": {
                                "FIELD_NAME": [
                                    "The FIELD NAME format is invalid."
                                ]
                            }
                        }
                RECORD ALREADY EXISTS WITH SAME EMAIL:
                    CODE: 409
                    DATA:
                        {
                            "success": false,
                            "message": "Validation Error.",
                            "data": {
                                "error": "UNIQUE_FIELD_COLLIDED",
                                "field": "email",
                                "count": 1
                            }
                        }
                RECORD ALREADY EXISTS WITH SAME CI:
                    CODE: 409
                    DATA:
                        {
                            "success": false,
                            "message": "Validation Error.",
                            "data": {
                                "error": "UNIQUE_FIELD_COLLIDED",
                                "field": "ci",
                                "count": 1
                            }
                        }
PUT    /api/user/:userID                           //UPDATES A USER RECORD
    REQUEST:
        TYPE: x-www-form-urlencoded
        DATA:
            REQUIRED: "email": VALID EMAIL ADDRESS,
            REQUIRED: "first_name": VALID STRING (/^[a-z ]{1,60}$/i) Letters and spaces, 1 to 60
            REQUIRED: "last_name": VALID STRING (/^[a-z ]{1,60}$/i) Letters and spaces, 1 to 60
            REQUIRED: "phone": [\d]{8,15} // only numbers (8 to 15 digits length)
            REQUIRED: "ci": [\d]{6,10} // only numbers (6 to 10 digits length)
    RESPONSE
        TYPE: JSON
        POSSIBLE RESPONSES:
            SUCCESS:
                RECORD HAS BEEN UPDATED:
                    CODE: 200
                    DATA:
                        {
                            "success": true,
                            "data": {
                                "email": String,
                                "first_name": String,
                                "last_name": String,
                                "phone": String,
                                "ci": String,
                                "updated_at": String,
                                "created_at": String,
                                "id": number
                            },
                            "message": "User created successfully."
                        }
            ERROR:
                REQUEST HAS INVALID DATA:
                    CODE: 400
                    DATA:
                        {
                            "success": false,
                            "message": "Validation Error.",
                            "data": {
                                "FIELD_NAME": [
                                    "The FIELD NAME format is invalid."
                                ]
                            }
                        }
                RECORD ALREADY EXISTS WITH SAME EMAIL:
                    CODE: 409
                    DATA:
                        {
                            "success": false,
                            "message": "Validation Error.",
                            "data": {
                                "error": "UNIQUE_FIELD_COLLIDED",
                                "field": "email",
                                "count": 1
                            }
                        }
                RECORD ALREADY EXISTS WITH SAME CI:
                    CODE: 409
                    DATA:
                        {
                            "success": false,
                            "message": "Validation Error.",
                            "data": {
                                "error": "UNIQUE_FIELD_COLLIDED",
                                "field": "ci",
                                "count": 1
                            }
                        }

DELETE    /api/user/:userID                           //DELETES A USER RECORD

</pre>