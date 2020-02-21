define({ "api": [
  {
    "type": "get",
    "url": "/auth/me",
    "title": "Return authenticated user data",
    "name": "GetMe",
    "group": "Auth",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/auth/me",
        "type": "curl"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"type\": \"success\",\n\"message\": null,\n\"data\" : {\n    \"user\": {\n        \"name\": \"Ian Torres\",\n        \"email\": \"iantorres@exmple.com\",\n        \"cpf\": \"39200029399\",\n        \"uuid\": \"888286e5-e508-4f28-a98d-1c56d2f036b0\",\n        \"role\": {\n            \"uuid\": \"888286e5-e508-4f28-a98d-1c56d2f036b0\",\n            \"name\": \"admin\",\n            \"descriotion\": \"This role is....\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Auth/AuthController.php",
    "groupTitle": "Auth",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Bearer Access Authentication token JWT</p>"
          }
        ]
      }
    }
  },
  {
    "type": "post",
    "url": "/auth/forgot",
    "title": "Reset password and send a email",
    "name": "PostForgot",
    "group": "Auth",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/auth/forgot\n body: {\n     \"email\": \"example@gmail.com\",\n}",
        "type": "curl"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"type\": \"success\",\n     \"message\": \"Email enviado com sucesso para sua caixa postal !!!\",\n     \"data\":[]\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Auth/ForgotPasswordController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/auth/refresh",
    "title": "Refresh user's token",
    "name": "PostRefresh",
    "group": "Auth",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/auth/refresh",
        "type": "curl"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"type\": \"success\",\n     \"message\": null,\n     \"data\" : {\n         \"access_token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9nYXAtYXBpLmxvY2FsXC9hdXRoXC9zaWduLWluIiwiaWF0IjoxNTM4MDk4MTE2LCJleHAiOjE1MzgxMDE3MTYsIm5iZiI6MTUzODA5ODExNiwianRpIjoicmZnaVJQd3hUNmkweFZycSIsInN1YiI6MSwicHJ2IjoiZmNkODY4YmRiMDY0MWVlODcwOGE2NDVlZmY1ODAzODAyZmRiZGUzOCJ9.F8N4Ep-by0LYHpVfKzwMcVJ2nksgrFa8D-FfKIOaVU8\",\n         \"token_type\":\"bearer\",\n         \"expires_in\":3600\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Auth/AuthController.php",
    "groupTitle": "Auth",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Bearer Access Authentication token JWT</p>"
          }
        ]
      }
    }
  },
  {
    "type": "post",
    "url": "/auth/resend",
    "title": "Resend email for verification",
    "name": "PostResend",
    "group": "Auth",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/auth/resend\n body: {\n     \"email\": \"example@gmail.com\"\n}",
        "type": "curl"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"type\": \"success\",\n     \"message\": \"Email reenviado com sucesso !!!\",\n     \"data\" : []\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Auth/VerificationController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/auth/reset",
    "title": "Reset user'spassword",
    "name": "PostReset",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password_confirmation",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": ""
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/auth/reset\nbody:\n{\n  \"token\": \"4bebf893be5db76792a7b1967c580f8829f476cb019ca8a817d2b3c14c2961ef\",\n  \"email\": \"email@example.com\",\n  \"password\": \"secret\",\n  \"password_confirmation\": \"secret\"\n}",
        "type": "curl"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"type\": \"success\",\n     \"message\": \"Sua senha foi redefinida com sucesso, autentique novamente !!!\",\n     \"data\" : []\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Auth/ResetPasswordController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/auth/sign-in",
    "title": "Sign In user",
    "name": "PostSignIn",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": ""
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/auth/sign-in\nbody:\n{\n  \"email\": \"email@example.com\",\n  \"password\": \"secret\"\n}",
        "type": "curl"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"type\": \"success\",\n     \"message\": null,\n     \"data\" : {\n         \"access_token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9nYXAtYXBpLmxvY2FsXC9hdXRoXC9zaWduLWluIiwiaWF0IjoxNTM4MDk4MTE2LCJleHAiOjE1MzgxMDE3MTYsIm5iZiI6MTUzODA5ODExNiwianRpIjoicmZnaVJQd3hUNmkweFZycSIsInN1YiI6MSwicHJ2IjoiZmNkODY4YmRiMDY0MWVlODcwOGE2NDVlZmY1ODAzODAyZmRiZGUzOCJ9.F8N4Ep-by0LYHpVfKzwMcVJ2nksgrFa8D-FfKIOaVU8\",\n         \"token_type\":\"bearer\",\n         \"expires_in\":3600\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Auth/AuthController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/auth/sign-out",
    "title": "Sign Out user",
    "name": "PostSignOut",
    "group": "Auth",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/auth/sign-out",
        "type": "curl"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"type\": \"success\",\n     \"message\": \"Usuário deslogado com sucesso !!!\"\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Auth/AuthController.php",
    "groupTitle": "Auth",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Bearer Access Authentication token JWT</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/auth/verify",
    "title": "Verify user's email",
    "name": "PostVerify",
    "group": "Auth",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/auth/verify?uuid=J07a83d66-e326-4859-b4df-079b7eee65bc",
        "type": "curl"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"type\": \"success\",\n     \"message\": \"Email verificado com sucesso !!!\",\n     \"data\" : []\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Auth/VerificationController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "get",
    "url": "/users",
    "title": "Return a list of user",
    "name": "GetUser",
    "group": "Users",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/users/list?search=jose%20Doe",
        "type": "curl"
      },
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/users/lists?search=john@gmail.com&searchFields=email:=",
        "type": "curl"
      },
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/users/list?search=name:John Doe;email:john@gmail.com",
        "type": "curl"
      },
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/users/list?search=cpf:20922394832",
        "type": "curl"
      },
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/users/list?search=name:John;email:john@gmail.com&searchFields=name:like;email:=",
        "type": "curl"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"type\": \"success\",\n     \"message\": \"\",\n     \"data\" : {\n         \"users\": [{\n             \"uuid\":\"07a83d66-e326-4859-b4df-079b7eee65bc\",\n             \"name\": \"José Maria\"\n             \"cpf\": \"28311194930\",\n             \"email\": \"jose@maria.com\"\n         }]\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "Users"
  },
  {
    "type": "post",
    "url": "/users",
    "title": "Create new user",
    "name": "PostUser",
    "group": "Users",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/users\nbody:\n{\n \"user\": {\n     \"name\": \"José de Arimateia\",\n     \"cpf\": \"29420039578\",\n     \"email\": \"email@example.com\",\n     \"password\": \"secret\"\n }\n}",
        "type": "curl"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"type\": \"success\",\n     \"message\": \"Usuário cadastrado com sucesso !!!\",\n     \"data\" : {\n         \"uuid\":\"07a83d66-e326-4859-b4df-079b7eee65bc\",\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "Users"
  },
  {
    "type": "put",
    "url": "/users/:uuid",
    "title": "Edit user",
    "name": "PutUser",
    "group": "Users",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "optional": false,
            "field": "status",
            "description": "<p>ACTIVE|INACTIVE</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/users/07a83d66-e326-4859-b4df-079b7eee65bc\nbody:\n{\n \"user\": {\n     \"name\": \"José de Arimateia\",\n     \"cpf\": \"29420039578\",\n     \"email\": \"email@example.com\",\n     \"active\": \"1\",\n}",
        "type": "curl"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"type\": \"success\",\n     \"message\": \"Usuário alterado com sucesso !!!\",\n     \"data\" : {\n         \"uuid\":\"07a83d66-e326-4859-b4df-079b7eee65bc\",\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "Users"
  }
] });
