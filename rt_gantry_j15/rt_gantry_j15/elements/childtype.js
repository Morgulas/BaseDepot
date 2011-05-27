window.addEvent('domready', function() {
	if (MooTools.version < "2") {
		var itemModules = $('paramsfusion_children_typemodules'), itemPositions = $('paramsfusion_children_typemodulepos'), itemMenu = $('paramsfusion_children_typemenuitems');
		var blockModules = $('paramsfusion_modules'), blockPositions = $('paramsfusion_module_positions');
	} else {
		var itemModules = document.id('paramsfusion_children_typemodules'), itemPositions = document.id('paramsfusion_children_typemodulepos'), itemMenu = document.id('paramsfusion_children_typemenuitems');
		var blockModules = document.id('paramsfusion_modules'), blockPositions = document.id('paramsfusion_module_positions');
	}
	if (blockModules) var blockModulesTr = blockModules.getParent().getParent();
	if (blockPositions) var blockPositionsTr = blockPositions.getParent().getParent();
	if (itemModules && blockModules) {
		itemModules.addEvent('click', function() {
			if (blockPositionsTr) blockPositionsTr.setStyle('display', 'none');
			if (blockModulesTr) blockModulesTr.setStyle('display', 'table-row');
			var tbody = blockModulesTr.getParent().getParent();
			var wrapper = tbody.getParent();
			if (wrapper.getStyle('height').toInt() > 0) {
				if (MooTools.version < "2")  wrapper.setStyle('height', tbody.getSize().size.y);
				else wrapper.setStyle('height', tbody.getSize().y);
			}
		});
	}
	if (itemPositions && blockPositions) {
		itemPositions.addEvent('click', function() {
			if (blockModulesTr) blockModulesTr.setStyle('display', 'none');
			if (blockPositionsTr) blockPositionsTr.setStyle('display', 'table-row');
			var tbody = blockPositionsTr.getParent().getParent();
			var wrapper = tbody.getParent();
			if (wrapper.getStyle('height').toInt() > 0) {
				if (MooTools.version < "2")  wrapper.setStyle('height', tbody.getSize().size.y);
				else wrapper.setStyle('height', tbody.getSize().y);
			}
		});
	}
	if (itemMenu) {
		itemMenu.addEvent('click', function() {
			if (blockModulesTr) blockModulesTr.setStyle('display', 'none');
			if (blockPositionsTr) blockPositionsTr.setStyle('display', 'none');
			var tbody = blockModulesTr.getParent().getParent();
			var wrapper = tbody.getParent();
			if (wrapper.getStyle('height').toInt() > 0) {
				if (MooTools.version < "2")  wrapper.setStyle('height', tbody.getSize().size.y);
				else wrapper.setStyle('height', tbody.getSize().y);
			}
		});
	}

	if (itemMenu.checked) itemMenu.fireEvent('click');
	if (itemModules.checked) itemModules.fireEvent('click');
	if (itemPositions.checked) itemPositions.fireEvent('click');
});