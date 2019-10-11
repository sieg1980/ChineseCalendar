#target InDesign;

#include "2020.jsx";
#include "base.jsx";

var year = 2020;
var ganZhi = ganZhi(year);

var doc = app.documents.add();
var page = null;

var width = 210;
var height = 140;
var marginTop = 15;
var marginRight = marginBottom = marginLeft = 5;
var mainFrameMarginTop = 35;

// 定义字体
var fontFYS = app.fonts.item("方正风雅宋简体");
var fontLTXH = app.fonts.item("方正兰亭纤黑简体");
var fontLTZH = app.fonts.item("方正兰亭中黑简体");

// 定义颜色
var red = doc.colors.add({
    name : "故宫红",
    model : ColorModel.process,
    colorValue : [15, 95, 100, 10]
});

var black = doc.colors.add({
    name : "乌黑",
    model : ColorModel.process,
    colorValue : [77, 71, 66, 25]
});

var silver = doc.colors.add({
    name : "银",
    model : ColorModel.process,
    colorValue : [14, 10, 8, 0]
});

// 设定页面尺寸
with(doc.documentPreferences) {
    pageWidth = width + "mm";
    pageHeight = height + "mm";
    pageOrientation = PageOrientation.landscape;
    pagesPerDocument = 26;
    documentBleedUniformSize = true;
    documentBleedTopOffset = "3mm";
    facingPages = false; // 不采用对页的形式
}

for(var month = 0; month < 12; month++)
{
	page = doc.pages.item(month * 2 + 1);

	with(page.marginPreferences) {
		top = marginTop + "mm";
		left = marginLeft + "mm";
		right = marginRight + "mm";
		bottom = marginBottom + "mm";
	}

	drawDayFrame(month);
}

function drawDayFrame(month)
{
	var cellWidth = (width - marginLeft - marginRight) / 7;
	var cellHeight = (height - mainFrameMarginTop - marginBottom) / 6;

	// 画外框
	for(var row = 0; row < 8; row++)
	{
		var x1 = x2 = row * cellWidth + marginLeft;
		var y1 = mainFrameMarginTop;
		var y2 = height - marginBottom;
		drawLine(x1, y1, x2, y2, black, 0.25);
	}
	
	for(var col = 0; col < 7; col++)
	{
		var x1 = marginLeft;
		var x2 = width - marginRight;
		var y1 = y2 = col * cellHeight + mainFrameMarginTop;
		drawLine(x1, y1, x2, y2, black, 0.25);
	}

	// 画月份
	var monthNumberFrame = drawText(page, month + 1 + "", marginLeft, 15, 100, 100, fontLTZH, black, 24, Justification.leftAlign);
	frameAutoFit(monthNumberFrame, AutoSizingReferenceEnum.TOP_LEFT_POINT);

	var monthFrame = drawText(page, "月", marginLeft + monthNumberFrame.geometricBounds[3] - monthNumberFrame.geometricBounds[1] + 0.5, 15, 100, monthNumberFrame.geometricBounds[2] - monthNumberFrame.geometricBounds[0] - 1, fontLTXH, black, 12, Justification.leftAlign);
	frameAutoFit(monthFrame, AutoSizingReferenceEnum.BOTTOM_LEFT_POINT);

	// 画年份
	var yearFrame = drawText(page, year + "·" + ganZhi + "年", marginLeft, monthFrame.geometricBounds[0], width - marginLeft - marginRight, monthFrame.geometricBounds[2] - monthFrame.geometricBounds[0], fontLTZH, black, 12, Justification.rightAlign);
	frameAutoFit(yearFrame, AutoSizingReferenceEnum.BOTTOM_RIGHT_POINT);

	// 画星期说明
	for(var w = 0; w < 7; w++)
	{
		var x = w * cellWidth + marginLeft;
		var y = mainFrameMarginTop - 5;

		if(w == 0 || w == 6) {
			color = red;
		} else {
			color = black;
		}

		var frame = drawText(page, "周" + weekDayName[w], x, y, cellWidth, 4, fontLTXH, color, 8, Justification.centerAlign);
			//frameAutoFit(frame, AutoSizingReferenceEnum.TOP_LEFT_POINT);
	}

	for(var row = 0; row < 7; row++)
	{
		for(var col = 0; col < 6; col++)
		{
			var color;
			var dayInfo = calendar[month][col * 7 + row];
			
			// 设定颜色
			if(dayInfo.weekday == 0 || dayInfo.weekday == 6) {
				color = red;
			} else {
				color = black;
			}
			
			if(dayInfo.grey) {
				color = silver;
			}

			var frame = drawText(page, dayInfo.day + "", row * cellWidth + marginLeft + 1, col * cellHeight + mainFrameMarginTop + 1, 20, 20, fontLTZH, color, 16, Justification.leftAlign);
			frameAutoFit(frame, AutoSizingReferenceEnum.TOP_LEFT_POINT);

			if(dayInfo.jieQi === null) {
				var special = dayInfo.lunarDay;
			} else {
				var special = dayInfo.jieQi;

				if(!dayInfo.grey) {
					color = red;
				}
			}

			frame = drawText(page, special, row * cellWidth  + marginLeft, col * cellHeight + mainFrameMarginTop + 1, cellWidth - 1, 20, fontLTXH, color, 8, Justification.rightAlign);
			frameAutoFit(frame, AutoSizingReferenceEnum.TOP_RIGHT_POINT);

			if(dayInfo.holiday !== null) {
				
				if(dayInfo.grey) {
					color = silver;
				} else {
					color = red;
				}

				frame = drawText(page, dayInfo.holiday, row * cellWidth  + marginLeft + 1, col * cellHeight + mainFrameMarginTop, cellWidth - 1, cellHeight - 1, fontLTXH, color, 8, Justification.leftAlign);
				frameAutoFit(frame, AutoSizingReferenceEnum.BOTTOM_LEFT_POINT);
			}
			
		}
	}
}