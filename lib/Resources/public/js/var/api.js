ag.api.Endpoint.register({
    "common.v1/Locale.search": [
        "common.v1/ScalarNull",
        "common.v1/Locale[]"
    ],
    "common.v1/Currency.search": [
        "common.v1/ScalarNull",
        "common.v1/Currency[]"
    ],
    "common.v1/Country.search": [
        "common.v1/ScalarNull",
        "common.v1/Country[]"
    ],
    "common.v1/Timezone.search": [
        "common.v1/ScalarNull",
        "common.v1/Timezone[]"
    ],
    "common.v1/Language.search": [
        "common.v1/ScalarNull",
        "common.v1/Language[]"
    ]
});
ag.api.Object.register({
    "common.v1/Locale": {
        "props": {
            "id": {
                "type": "string"
            },
            "name": {
                "type": "string"
            }
        }
    },
    "common.v1/Currency": {
        "props": {
            "id": {
                "type": "string"
            },
            "name": {
                "type": "string"
            },
            "symbol": {
                "type": "string"
            },
            "digits": {
                "type": "integer"
            }
        }
    },
    "common.v1/Country": {
        "props": {
            "id": {
                "type": "string"
            },
            "name": {
                "type": "string"
            }
        }
    },
    "common.v1/Timezone": {
        "props": {
            "id": {
                "type": "string"
            },
            "name": {
                "type": "string"
            }
        }
    },
    "common.v1/Language": {
        "props": {
            "id": {
                "type": "string"
            },
            "name": {
                "type": "string"
            }
        }
    }
});
