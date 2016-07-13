@extends('app')

@section('content')

    <div id="createJobView" ng-controller="createjobCtrl">

        <h1>Aanvraag aanmaken</h1>

        <section class="col-md-12" id="inventoryitemlist">

            <h2>Beschikbare items</h2>

            <div class="ui fluid input">
                <input type="text" class="inventory-search" placeholder="Search...">
            </div>

            <div class="resultstable">

                <table class="ui single line selectable striped table" id="inventoryItemTable">
                    <thead>
                    <tr>
                        <th>Code</th>
                        <th>Item</th>
                        <th>Locatie</th>
                        <th>Staat</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr class="datarow" ng-repeat="item in inventoryItems">
                        <th><img src="/libraries/barcode.php?size=60&text=<% item.code %>" alt=""></th>
                        <td><% item.name %></td>
                        <td><% item.location.name %></td>
                        <td><% item.condition.name %></td>
                        <td><a href="#" ng-click="addItemToJobList(item)"><i class="fa fa-plus"></i></a></td>
                    </tr>

                    </tbody>
                </table>

            </div>

        </section>

        <section id="joblist" class="col-md-12">

            <h2>Info & overzicht aanvraag</h2>

            <form class="ui form">

                <div class="jobtable">

                    <table class="ui single line selectable striped table" id="jobItemTable">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Item</th>
                            <th>Staat</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr class="datarow" ng-repeat="item in currentJobList">
                            <th><% item.code %></th>
                            <td><% item.name %></td>
                            <td><% item.condition.name %></td>
                            <td><a href="#" ng-click="removeItemFromJobList(item)"><i class="fa fa-remove"></i></a></td>
                        </tr>

                        </tbody>
                    </table>

                </div>

                <div class="field">
                    <label>Aanvrager</label>
                    <select class="ui search dropdown">
                        <option value="">Selecteer...</option>
                        <option ng-repeat="location in locationsList" value="<% location.id %>"><% location.name %></option>
                    </select>
                </div>

                <div class="field">
                    <label>Opmerkingen:</label>
                    <textarea name="opmerkingen" id="opmerkingen"></textarea>
                </div>

                <a class="ui button" href="saveJob">Submit</a>
            </form>

        </section>

    </div>

@endsection