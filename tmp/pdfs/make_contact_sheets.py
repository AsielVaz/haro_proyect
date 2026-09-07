from pathlib import Path
from PIL import Image, ImageDraw, ImageFont

folder = Path(r"C:\laragon\www\haro_proyect\tmp\pdfs\render")
pages = sorted(folder.glob("page-*.png"))
for sheet_no, start in enumerate(range(0, len(pages), 8), 1):
    group = pages[start:start + 8]
    thumb_w, thumb_h = 330, 467
    gutter, label_h = 18, 26
    canvas = Image.new("RGB", (4 * thumb_w + 5 * gutter, 2 * (thumb_h + label_h) + 3 * gutter), "#dfe3e8")
    draw = ImageDraw.Draw(canvas)
    for idx, page in enumerate(group):
        image = Image.open(page).convert("RGB")
        image.thumbnail((thumb_w, thumb_h), Image.Resampling.LANCZOS)
        col, row = idx % 4, idx // 4
        x = gutter + col * (thumb_w + gutter)
        y = gutter + row * (thumb_h + label_h + gutter)
        canvas.paste(image, (x + (thumb_w - image.width) // 2, y))
        draw.text((x, y + thumb_h + 4), page.stem.replace("page-", "Página "), fill="#1f2933")
    canvas.save(folder / f"contact-sheet-{sheet_no}.png", quality=92)
