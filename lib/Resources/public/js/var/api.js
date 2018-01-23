ag.api.Endpoint.register({
    "localedata.v1/Locale.search": [
        "common.v1/ScalarNull",
        "localedata.v1/Locale[]"
    ],
    "localedata.v1/Currency.search": [
        "common.v1/ScalarNull",
        "localedata.v1/Currency[]"
    ],
    "localedata.v1/Country.search": [
        "common.v1/ScalarNull",
        "localedata.v1/Country[]"
    ],
    "localedata.v1/Timezone.search": [
        "common.v1/ScalarNull",
        "localedata.v1/Timezone[]"
    ],
    "localedata.v1/Language.search": [
        "common.v1/ScalarNull",
        "localedata.v1/Language[]"
    ]
});
ag.api.Object.register({
    "localedata.v1/Locale": {
        "props": {
            "id": {
                "type": "string"
            },
            "name": {
                "type": "string"
            }
        }
    },
    "localedata.v1/Currency": {
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
    "localedata.v1/Country": {
        "props": {
            "id": {
                "type": "string"
            },
            "name": {
                "type": "string"
            }
        }
    },
    "localedata.v1/Timezone": {
        "props": {
            "id": {
                "type": "string"
            },
            "name": {
                "type": "string"
            }
        }
    },
    "localedata.v1/Language": {
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
