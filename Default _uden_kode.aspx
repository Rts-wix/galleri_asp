<%@ Page Title="" Language="C#" MasterPageFile="~/MasterPage.master" AutoEventWireup="true" CodeFile="Default _uden_kode.aspx.cs" Inherits="_Default" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_head" Runat="Server">
</asp:Content>
<asp:Content ID="Content2" runat="server" contentplaceholderid="ContentPlaceHolder_Content">
    <div id="content_midt">
       
    </div>
    <div id="content_right">

                    <!--
                    
                            BILLEDUDTRÆK START:
                            Herunder er forsidens 8 billeder defineret statisk. Jeres opgave er at generere et 
                            dynamisk udtræk, begrænset til 8 tilfældige billeder, fra de 3 album kategorier.

                            Vis et enkelt billede:
                            1. Hvert thumbnail skal være et link som peger på den store udgave af billedet på serveren.
                            2. Brug billedet ID via URL'en til at hente det fra serveren.

                            I PRAKSIS:
                            1. DB: Opret forbindelse til projektes database.
                            2. SQL: Hent relevant data fra databasen.
                            3. PHP/C#: Benyt en løkke til at udskrive resultatet.
                    
                    -->
        <asp:Repeater ID="RepeaterBilleder" runat="server" DataSourceID="SqlDataSourceBillede">
            <ItemTemplate>
                <div class="ikon">
                    <a href="billedeStor.aspx?billedeId=<%# Eval("Id") %>">
                        <img src='foto_ikon/<%# Eval("billedfilnavn") %>'
                            alt='<%# Eval("beskrivelse") %>' /></a>
                </div>
            </ItemTemplate>
        </asp:Repeater>





        <!--

                            BILLEDUDTRÆK SLUT!

                    -->

        <asp:SqlDataSource 
            runat="server" 
            ID="SqlDataSourceBillede" 
            ConnectionString='<%$ ConnectionStrings:DatabaseConnectionString1 %>' 
            SelectCommand="SELECT * FROM [Billede]"></asp:SqlDataSource>
    </div>
</asp:Content>


