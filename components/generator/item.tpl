<?xml version='1.0' standalone='yes'?>
<schema>
    <model>
        <table>item</table>
        <class>Item</class>
        <properties>
		    <prop attributes="type: Integer, method: AutoIncrement">id</prop>
			<prop attributes="type: String, size: 200">id_venda</prop>
			<prop attributes="type: Email, size: 20">id_produto</prop>
			<prop attributes="type: Url, size: 20">quantidade</prop>
			<prop attributes="type: Date, method: Now">datecreate</prop>
        </properties>
    </model>

<views>
    <template>getAllItem.tpl</template>
    <template>getIdItem.tpl</template> 
</views>
</schema>
