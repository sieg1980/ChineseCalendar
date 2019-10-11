const weekDayName = ['日', '一', '二' , '三', '四', '五', '六'];
const nameOfStems = ["甲", "乙", "丙", "丁", "戊", "己", "庚", "辛", "壬", "癸"];
const nameOfBranches = ["子", "丑", "寅", "卯", "辰", "巳", "午", "未", "申", "酉", "戌", "亥"];
const nameOfShengXiao = ["鼠", "牛", "虎", "兔", "龙", "蛇", "马", "羊", "猴", "鸡", "狗", "猪"];

function ganZhi(year)
{
    var n = year - 1984;
    
    while (n < 0)
        n += 60;

    return nameOfStems[n % 10] + nameOfBranches[n % 12];
}

function drawLine(x1, y1, x2, y2, color, weight)
{
    var line = page.graphicLines.add();
    line.geometricBounds = [y1, x1, y2, x2];
    line.strokeColor = color;
    line.strokeWeight = weight;
}

function drawText(page, content, x, y, width, height, font, color, size, align, autofit)
{
    var textFrame = page.textFrames.add();

    textFrame.geometricBounds = [y, x, y + height, x + width];
    textFrame.contents = content;

    for(var i = 0; i < textFrame.parentStory.paragraphs.length; i++)
    {
        var textObject = textFrame.parentStory.paragraphs.item(i);

        textObject.appliedFont = font;
        textObject.fillColor = color;
        textObject.pointSize = size;
        textObject.justification = align;
    }

    return textFrame;
}

function frameAutoFit(frame, refPoint)
{
	with(frame.textFramePreferences)
	{
        autoSizingReferencePoint = refPoint;
        autoSizingType = AutoSizingTypeEnum.HEIGHT_ONLY;
        autoSizingType = AutoSizingTypeEnum.WIDTH_ONLY;
	}
}