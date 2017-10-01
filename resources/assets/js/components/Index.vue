<template>
    <div id="temperature-converter">
        <header>
            <h1>Temperature converter</h1>
        </header>

        <div class="row" v-if="validationErrorsMessage">
            <div class="col">
                <div class="alert alert-danger" role="alert">
                    {{ validationErrorsMessage }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="from">From:</label>
                <div class="form-group">
                    <select v-model="scaleFrom" v-on:change="convertTemperature()" class="form-control" name="from" id="from">
                        <option v-for="scale in scales" v-bind:value="scale.symbol">{{ scale.text }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="number"
                           step="0.01"
                           v-model="temperatureFrom"
                           v-on:input="keyUpTemperatureFrom()"
                           v-bind:class="{ 'is-invalid': validationErrors.hasOwnProperty('temperature')}"
                           class="form-control"/>
                </div>
            </div>
            <div class="col-sm-auto">
                <label for="from">&nbsp;</label>
                <div class="form-group">
                    <button type="button" class="btn btn-dark" v-on:click="swap">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="form-group text-center">
                    <label>
                        <h2>=</h2>
                    </label>
                </div>
            </div>
            <div class="col">
                <label for="to">To:</label>
                <div class="form-group">
                    <select
                            v-model="scaleTo"
                            v-on:change="convertTemperature()"
                            class="form-control"
                            name="to"
                            id="to">
                        <option v-for="scale in scales" v-bind:value="scale.symbol">{{ scale.text }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" v-model="temperatureTo" class="form-control" readonly/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'converter',
        data: function () {
            return {
                scaleFrom: 'C',
                scaleTo: 'F',
                temperatureFrom: 0,
                temperatureTo: null,
                scales: [
                    {symbol: "C", text: 'Celsius'},
                    {symbol: "F", text: 'Fahrenheit'},
                    {symbol: 'K', text: 'Kelvin'},
                ],
                validationErrorsMessage: "",
                validationErrors: {},
            };
        },
        methods: {
            swap: function (event) {
                const tmp = this.scaleFrom;
                this.scaleFrom = this.scaleTo;
                this.scaleTo = tmp;
                this.convertTemperature();
            },
            keyUpTemperatureFrom: _.debounce(function () {
                this.convertTemperature();
            }, 500),
            convertTemperature: function () {
                NProgress.start();
                this.temperatureTo = '';
                this.validationErrorsMessage = "";
                this.validationErrors = {};

                axios.post('/convert', this.getData())
                    .then(response => {
                        this.temperatureTo = response.data.formatted;
                        NProgress.done();
                    })
                    .catch(e => {
                        this.validationErrorsMessage = e.response.data.message;
                        this.validationErrors = e.response.data.errors;
                        NProgress.done();
                    });
            },
            getData: function () {
                return {
                    from: this.scaleFrom,
                    to: this.scaleTo,
                    temperature: this.temperatureFrom
                };
            },
            has: Object.prototype.hasOwnProperty,
        },
        mounted: function () {
            this.convertTemperature();
        }
    }
</script>
