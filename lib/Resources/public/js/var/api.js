ag.api.Endpoint.register({
    "common.v1/Locale.search": [
        "null",
        "common.v1/Locale[]"
    ],
    "common.v1/Currency.search": [
        "null",
        "common.v1/Currency[]"
    ],
    "common.v1/Country.search": [
        "null",
        "common.v1/Country[]"
    ],
    "common.v1/Timezone.search": [
        "null",
        "common.v1/Timezone[]"
    ],
    "common.v1/Language.search": [
        "null",
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
